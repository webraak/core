<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\app\com_webraak_manager\controller\api\v1;

use webraak\app\com_webraak_manager\controller\api\ApiConfiguration;
use webraak\app\com_webraak_manager\model\LangModel;
use webraak\component\app\AppProvider;
use webraak\component\Router;

class MasterConfiguration extends ApiConfiguration
{

    const manualPath = 'downloads/packages/manual/';

    public function __construct()
    {
        parent::__construct();
    }

}
    
