<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_installer\controller;

use webraak\component\HelperHeader;
use webraak\component\Response;
use webraak\component\Router;

class MainController extends MasterConfiguration
{
    public function _main()
    {
        self::$template->view('index');
    }

    public function _exception()
    {
        Response::redirect(url('lang'));
    }


    public function lang()
    {
        $this->_main();
    }

    public function setup()
    {
        $this->_main();
    }

    public function rules()
    {
        $this->_main();
    }

    public function prerequisites()
    {
        $this->_main();
    }

    public function db()
    {
        $this->_main();
    }

    public function user()
    {
        Response::redirect(url('db'));
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
    
