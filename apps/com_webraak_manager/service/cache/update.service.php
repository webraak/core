<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_manager\service\cache;

use webraak\component\Cache;
use webraak\component\Config;
use webraak\component\Download;
use webraak\component\HelperString;
use webraak\component\HttpRequest;
use webraak\component\interfaces\ServiceInterface;
use webraak\component\Request;
use webraak\component\Url;

class UpdateService implements ServiceInterface
{

    public function _run()
    {
        Cache::init('version',function () {

            $webraak = Config::get('~webraak');
            $data = Request::sendPost(
                'https://www.webraak.com/api/v1/update/checkVersion/',
                [
                    'domain' => Url::domain(),
                    'site' => Url::site(), 'app' => Url::app(),
                    'version_name' => $webraak['version_name'],
                    'version_code' => $webraak['version_code'],
                    'php' => phpversion()
                ],
                [
                    'timeout' => 8000,
                    'type' => HttpRequest::form,
                ]
            );

            return HelperString::decodeJson($data);
        },(5*24));
    }

    public function _stop()
    {
    }
}
    
