<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_manager\controller\api\v1;

use webraak\component\app\AppProvider;
use webraak\component\Config;
use webraak\component\Dir;
use webraak\component\Response;

class OptionsController extends LoginConfiguration
{
    public function changeBackground($name)
    {
        $path = Dir::theme('dist/images/backgrounds/' . $name . '.jpg');
        if (is_file($path)) {
            Config::set('options.background', $name);
            Config::save('options');
            Response::json($name, true);
        }

        Response::json($name, false);
    }

    public function changeLockTime($minutes=0)
    {
        switch ($minutes) {
            case 10:
                break;
            case 20:
                break;
            case 30:
                break;
            case 60:
                break;
            default:
                $minutes = 0;
                break;
        }

        $lock_time = Config::get('options.lock_time');
        if ($lock_time != $minutes) {
            Config::set('options.lock_time', $minutes);
            Config::save('options');
            Response::json($minutes, true);
        }

        Response::json($minutes, false);
    }
}
    
