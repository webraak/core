<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\service;

use webraak\component\interfaces\ServiceInterface;
use webraak\component\Router;

class RouterService implements ServiceInterface
{

    public function _run()
    {
        Router::start();
        Router::call();
    }

    public function _stop()
    {
    }
}

