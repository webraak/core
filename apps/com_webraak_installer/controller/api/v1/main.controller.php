<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_installer\controller\api\v1;

use webraak\component\app\AppProvider;
use webraak\component\Cache;
use webraak\component\Config;
use webraak\component\DB;
use webraak\component\Dir;
use webraak\component\HelperArray;
use webraak\component\Lang;
use webraak\component\Request;
use webraak\component\Response;
use webraak\component\Service;
use webraak\component\System;
use webraak\component\Validation;
use webraak\model\WebraakDatabase;
use webraak\model\UserModel;

class MainController extends MasterConfiguration
{
    public function changeLang($lang)
    {
        $lang = strtolower($lang);
        AppProvider::set('lang', $lang);
        AppProvider::save();
        Lang::change($lang);
        Response::json($this->getLang());
    }

    public function checkDB()
    {
        $data = Request::input('host,database,username,password,prefix', '', '!empty');

        $isConnected = DB::checkConnect($data['host'], $data['username'], $data['password'], $data['database']);

        if ($isConnected) {
            Response::json(null, true);
        }

        Response::json(null, false);
    }

    public function checkPrerequisites($type)
    {
        $status = false;
        switch ($type) {
            case 'php' :
                $status = (version_compare(System::phpVersion(), '5.6', '>='))? true : false;
                break;
            case 'mysql' :
                /**
                 * fixme: Version mysql cannot be found on all operating systems
                 */
                // $vMysql = System::mysqlVersion();
                $status = true;//(!empty($vMysql)) ? version_compare($vMysql, '5.5', '>=') : true;
                break;
            case 'free_space' :
                /**
                 * fixme: The required space cannot be found on all operating systems
                 */
                $status = true;//(System::freeSpace('MB') > 50);
                break;
            case 'mod_rewrite' :
                /**
                 * fixme: The mod_rewrite status cannot be found on all operating systems
                 */
                $status = true;//System::hasModuleApache('mod_rewrite');
                break;
        }


        Response::json($type, $status);
    }

    public function agreement()
    {
        lang('agreement');
    }

    public function setup()
    {
        $inputs = Request::input('user,db', [], '!empty');
        $user = HelperArray::parseParams($inputs['user'], 'fname,lname,username,password,email', null, '!empty');
        $db = HelperArray::parseParams($inputs['db'], 'host,database,username,password,prefix', null, '!empty');

        $valid = Validation::check($user, [
            'fname' => ['required|length:>2', rlang('user.name')],
            'lname' => ['required|length:>2', rlang('user.family_name')],
            'email' => ['required|email', rlang('user.email')],
            'username' => ['required|length:>2|username', rlang('user.username')],
            'password' => ['required|length:>5', rlang('user.password')],
        ]);

        if ($valid->isFail())
            Response::json($valid->first(), false);

        if (!$this->insertTables($db, $user)) {
            Response::json(rlang('install.err_insert_tables'), false);
        }

        $app = Config::get('app');
        Config::set('~app', $app);
        Config::save('~app');

        $lang = AppProvider::get('lang');
        AppProvider::set('enable', false);
        AppProvider::save();

        // change lang app welcome
        AppProvider::app('com_webraak_welcome');
        AppProvider::set('lang', $lang);
        AppProvider::save();

        // change lang app manager
        AppProvider::app('com_webraak_manager');
        AppProvider::set('lang', $lang);
        AppProvider::save();

        // run service update & caching last version
        Cache::app('com_webraak_manager');
        Service::app('com_webraak_manager');
        Service::run('cache/update');

        Response::json(null, true);
    }

    private function insertTables($c, $user)
    {
        if (empty($c))
            return false;

        $isConnected = DB::checkConnect($c['host'], $c['username'], $c['password'], $c['database']);
        if (!$isConnected) return false;

        Config::set('~database', $c);
        $file = Dir::path("webraak.db");
        if (!is_file($file))
            return false;

        $query = file_get_contents($file);
        $query = str_replace('{dbprefix}', $c['prefix'], $query);
        $queryArr = explode(';', $query);

        WebraakDatabase::__init();
        WebraakDatabase::startTransaction();
        foreach ($queryArr as $q) {
            if (empty($q)) continue;
            WebraakDatabase::$db->mysqli()->query($q);
        }
        $user['app'] = 'com_webraak_manager';
        UserModel::insert($user);
        WebraakDatabase::commit();
        Config::save('~database');
        return true;
    }

}
    
