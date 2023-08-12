<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_installer\controller\api;

use webraak\component\interfaces\ControllerInterface;
use webraak\component\Response;
use webraak\component\Router;
use webraak\component\Template;
use webraak\component\Url;

class ApiConfiguration implements ControllerInterface
{

    public function __construct()
    {
    }

    public function _main()
    {
        $this->error();
    }

    public function _exception()
    {
        $this->error();
    }

    public function error()
    {
        Response::json('not found',404);
    }
}
    
