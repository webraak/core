<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_installer\controller\api\v1;

use webraak\app\com_webraak_installer\controller\api\ApiConfiguration;
use webraak\component\app\AppProvider;

class MasterConfiguration extends ApiConfiguration
{

    public function __construct()
    {
        parent::__construct();
    }

    protected function getLang($lang = null)
    {
        $lang = empty($lang) ? AppProvider::get('lang') : $lang;
        return [
            'direction' => in_array($lang, ['fa', 'ar']) ? 'rtl' : 'ltr',
            'lang' => [
                'install' => rlang('install'),
                'user' => rlang('user'),
                'language' => rlang('language'),
            ]
        ];
    }
}
    
