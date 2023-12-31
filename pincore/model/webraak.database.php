<?php
/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

namespace webraak\model;

use webraak\component\Config;
use webraak\component\DB;
use webraak\component\MagicTrait;
use webraak\component\source\Database;

class WebraakDatabase extends Database
{
    use MagicTrait;

    const session = 'pincore_session';
    const user = 'pincore_user';
    const file = 'pincore_file';
    const token = 'pincore_token';

    private static $config = [];

    public static function __init()
    {
        self::$config = Config::get('~database');
        self::$db = new DB(
            self::$config['host'],
            self::$config['username'],
            self::$config['password'],
            self::$config['database'],
            null,
            null,
            'utf8mb4'
        );
    }


    public static function startTransaction()
    {
        self::$db->startTransaction();
    }

    public static function commit()
    {
        self::$db->commit();
    }

    public static function rollback()
    {
        self::$db->rollback();
    }

    public static function stopQuery()
    {
        self::$db->setTrace(true);
    }

    public static function printQuery()
    {
        return self::$db->trace;
    }

    public static function getTables($app = null)
    {
        //$query = 'SHOW TABLES';
        //$query = (!empty($app))? $query.' LIKE "'.self::$db->escape($app).'%"' : $query;
        if(!empty($app))
            self::$db->where('table_name',$app.'%','LIKE');
        self::$db->where('table_schema', self::$config['database']);
        $result = self::$db->get('information_schema.TABLES',null, 'table_name');
        $result = array_column($result,'table_name');

        return $result;
    }
}
    
