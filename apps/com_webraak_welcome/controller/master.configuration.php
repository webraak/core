<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_welcome\controller;

use webraak\component\interfaces\ControllerInterface;
use webraak\component\Response;
use webraak\component\Template;

class MasterConfiguration implements ControllerInterface{

    protected static $template;

    public function __construct()
    {
        self::$template = new Template();
    }

    public function _main()
    {
        Response::redirect(url());
    }

    public function _exception()
    {
        Response::redirect(url());
    }
}
