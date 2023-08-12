<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_manager\controller\api\v1;

use webraak\app\com_webraak_manager\model\LangModel;
use webraak\component\app\AppProvider;
use webraak\component\Config;
use webraak\component\Lang;
use webraak\component\Response;

class MainController extends LoginConfiguration
{
    public function changeLang($lang)
    {
        $lang = strtolower($lang);
        AppProvider::set('lang', $lang);
        AppProvider::save();
        Lang::change($lang);
        $total_lang = LangModel::fetch_all();
        $direction = $total_lang['manager']['direction'];
        Response::json(['lang' => $total_lang, 'direction' => $direction]);
    }

}
    
