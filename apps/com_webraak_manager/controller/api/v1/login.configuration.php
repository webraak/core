<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_manager\controller\api\v1;

use webraak\component\User;

class LoginConfiguration extends MasterConfiguration
{
    public function __construct()
    {
        parent::__construct();
        if(!User::isLoggedIn())
        {
            $this->error();
        }
    }
}
