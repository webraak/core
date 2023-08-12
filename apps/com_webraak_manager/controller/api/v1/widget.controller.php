<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
namespace webraak\app\com_webraak_manager\controller\api\v1;

use webraak\component\app\AppProvider;
use webraak\component\Date;
use webraak\component\File;
use webraak\component\Response;
use webraak\component\System;

class WidgetController extends LoginConfiguration
{
    public function clock()
    {
        $isJalali = (AppProvider::get('lang') === 'fa');
        $date = $isJalali? Date::j('d F Y') : Date::g('d F Y');

        Response::json([
           'time' => time(),
           'date' => rlang('widget>clock.today').' '.$date,
           'moment' => $isJalali? Date::j('a') :  Date::g('a'),
       ]);
    }

    public function storage()
    {
        $totalSpace = System::totalSpace();
        $freeSpace = System::freeSpace();
        $useSpace = System::useSpace();
        $percent = round($useSpace / ($totalSpace / 100));

        Response::json([
            'total' => round($totalSpace, 1),
            'free' => round($freeSpace, 1),
            'use' => round($useSpace, 1),
            'percent' => $percent,
        ]);
    }
}
    
