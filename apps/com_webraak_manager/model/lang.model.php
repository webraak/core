<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_manager\model;

use webraak\model\WebraakDatabase;

class LangModel extends WebraakDatabase
{

    public static function fetch_all()
    {
        return [
            'manager' => rlang('manager'),
            'user' => rlang('user'),
            'setting' => [
                'account' => rlang('setting>account'),
                'dashboard' => rlang('setting>dashboard'),
                'market' => rlang('setting>market'),
                'router' => rlang('setting>router'),
                'appManager' => rlang('setting>appManager'),
            ],
            'widget' => [
                'clock' => rlang('widget>clock'),
                'storage' => rlang('widget>storage'),
            ],
        ];
    }
}