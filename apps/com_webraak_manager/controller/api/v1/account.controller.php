<?php
/**

 * @license    https://opensource.org/licenses/MIT MIT License
 * @link       webraak.com
 * @copyright  webraak
 */


namespace webraak\app\com_webraak_manager\controller\api\v1;

use webraak\component\Config;
use webraak\component\HelperString;
use webraak\component\HttpRequest;
use webraak\component\Request;
use webraak\component\Response;
use webraak\component\Url;
use webraak\component\Validation;

class AccountController extends LoginConfiguration
{

    public function login()
    {
        $form = Request::input('email,password', null, '!empty');

        $valid = Validation::check($form, [
            'email' => ['required', rlang('user.username_or_email')],
            'password' => ['required', rlang('user.password')],
        ]);

        if ($valid->isFail())
            Response::json($valid->first(), false);

        $form['remote_url'] = Url::site();

        $data = Request::sendPost(
            'https://www.webraak.com/api/manager/v1/account/login',
            $form,
            [
                'type' => HttpRequest::form,
                'timeout' => 8000
            ]
        );
        $array = json_decode($data, true);
        if ($array['status']) {
            Config::set('connect.token_key', $array['result']['token']);
            Config::save('connect');
        }
        exit($data);
    }

    public function getWebraakAuth()
    {
        $token_key = Config::get('connect.token_key');
        $data = Request::sendPost(
            'https://www.webraak.com/api/manager/v1/account/getData',
            [
                'remote_url' => Url::site(),
                'token_key' => $token_key,
            ],
            [
                'type' => HttpRequest::form,
                'timeout' => 8000
            ]
        );

        $data = HelperString::decodeJson($data);
        if($data['status'])
        {
            Response::json($data['result']);
        }

        Response::json(null);
    }

    public function connect()
    {
        $data = Request::sendPost(
            'https://www.webraak.com/api/manager/v1/account/getToken',
            [
                'remote_url' => Url::site(),
            ],
            [
                'type' => HttpRequest::form,
                'timeout' => 8000
            ]
        );

        $array = json_decode($data, true);
        if (!empty($array['token_key'])) {
            Config::set('connect.token_key', $array['token_key']);
            Config::save('connect');

            Response::json($array['token_key'], true);
        }

        Response::json(null, false);
    }

    public function getConnectData()
    {
        $data = Config::get('connect');
        Response::json($data);
    }

    public function logout()
    {
        Config::set('connect.token_key',null);
        Config::save('connect');
    }
}