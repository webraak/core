<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
    
namespace webraak\service;

use webraak\component\Config;
use webraak\component\interfaces\ServiceInterface;
use webraak\component\Session;
use webraak\model\WebraakDatabase;

class SessionService implements ServiceInterface
{

    public function _run()
    {
        $dbConfig = Config::get('~database');
        if (empty($dbConfig) || isset($dbConfig['isLock']) || !WebraakDatabase::$db->tableExists('session'))
            $store_in_file = true;
        else
            $store_in_file = false;

        $session = new Session($store_in_file);
        $session::gcProbability(0);
        $session->lifeTime(365, 'day');
        //$session->refresh_lifetime_in_requests(true);
        $session->securityToken(true);
        $session->encryption(false);
        $session->nonBlocking(false);
        $session->start();
    }

    public function _stop()
    {
    }
}
