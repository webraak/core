<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_installer\controller;

use webraak\component\app\AppProvider;
use webraak\component\Dir;
use webraak\component\HelperString;
use webraak\component\interfaces\ControllerInterface;
use webraak\component\Response;
use webraak\component\Template;

class MasterConfiguration implements ControllerInterface
{
    protected static $template;

    public function __construct()
    {
        self::$template = new Template();
        $this->getAssets();
        $this->setLang();
    }

    private function setLang()
    {
        $lang = AppProvider::get('lang');
        $direction = in_array($lang, ['fa', 'ar']) ? 'rtl' : 'ltr';
        $data = HelperString::encodeJson([
            'install' => rlang('install'),
            'user' => rlang('user'),
            'language' => rlang('language'),
        ], true);
        self::$template->set('_lang', $data);
        self::$template->set('_direction', $direction);
        self::$template->set('currentLang', $lang);

    }

    private function getAssets()
    {
        $css = 'main.css';
        $js = 'main.js';
        $path = Dir::theme('dist/manifest.json');
        if (is_file($path)) {
            $manifest = file_get_contents($path);
            $manifest = HelperString::decodeJson($manifest)['main'];

            foreach ($manifest as $item) {
                if (HelperString::has($item, 'main.js'))
                    $js = $item;
                else if (HelperString::has($item, 'main.css'))
                    $css = $item;
            }
        }
        self::$template->assets = ['js' => $js, 'css' => $css];
    }

    public function _main()
    {
        Response::redirect(url());
    }

    public function _exception()
    {
        Response::redirect(url());
    }

    public function _404()
    {
        Response::redirect(url());
        exit;
    }
}