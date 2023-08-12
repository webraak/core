<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_welcome\controller;

use webraak\component\Download;

class MainController extends MasterConfiguration
{

    public function _main()
    {
        self::$template->show('hello');
    }
}