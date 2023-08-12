<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_manager\controller;

use webraak\app\com_webraak_manager\model\AppModel;
use webraak\component\Config;
use webraak\component\HelperHeader;
use webraak\component\HelperString;
use webraak\component\Request;
use webraak\component\Response;
use webraak\component\Router;
use webraak\component\User;

class MainController extends MasterConfiguration
{
    public function _exception()
    {
        $this->_main();
    }

    public function app($package_name)
    {
        if (User::isLoggedIn() && Router::existApp($package_name)) {
            $app = AppModel::fetch_by_package_name($package_name);
            if ($app['enable'] && !$app['sys-app']) {
                self::$template = null;
                User::reset();
                Router::build('manager/app/' . $package_name, $package_name);
                exit;
            }
        }
        $this->_main();
    }

    public function _main()
    {
        self::$template->view('index');
    }

    public function dist()
    {
        $url = implode('/', Router::params());
        if ($url === 'webraak.js') {
            HelperHeader::contentType('application/javascript', 'UTF-8');
            self::$template->view('dist/webraak.js');
        } else {
            $this->_main();
        }
    }
}