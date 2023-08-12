<?php


/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_manager\service\app;

use webraak\app\com_webraak_manager\component\Wizard;
use webraak\component\Config;
use webraak\component\Dir;
use webraak\component\File;
use webraak\component\interfaces\ServiceInterface;
use webraak\component\User;
use webraak\model\WebraakDatabase;
use webraak\model\UserModel;

class UpdateService implements ServiceInterface
{

    public function _run()
    {
        Config::remove('options.webraak_auth');
        Config::save('options');

        $dir = Dir::path('pinupdate/','com_webraak_manager');
        if(!is_dir($dir))
            return;

        $webraak_version_code = config('~webraak.version_code');
        $files = File::get_files_by_pattern($dir, '*.db');

        foreach ($files as $file) {
            $version_code = File::name($file);
            if ($webraak_version_code <= $version_code) {
                $this->runQuery($file);
            }
        }

        File::remove($dir);
    }

    private static function runQuery($appDB)
    {
        if (is_file($appDB)) {
            $package_name = 'com_webraak_manager';

            $prefix = Config::get('~database.prefix');
            $query = file_get_contents($appDB);
            $query = str_replace('{dbprefix}', $prefix . $package_name . '_', $query);
            $queryArr = explode(';', $query);

            WebraakDatabase::$db->startTransaction();
            foreach ($queryArr as $q) {
                if (empty($q)) continue;
                WebraakDatabase::$db->mysqli()->query($q);
            }

            WebraakDatabase::$db->commit();

            File::remove_file($appDB);

            return true;
        }
        return false;
    }

    public function _stop()
    {
    }
}
