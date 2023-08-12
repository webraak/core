<?php
/**
 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */
use webraak\boot\Loader;

define('WEBRAAK_DEFAULT_LANG', 'en');
define('WEBRAAK_PATH',realpath(dirname(__FILE__) . '/../..').DIRECTORY_SEPARATOR);
require_once(dirname(__FILE__) . DIRECTORY_SEPARATOR . "loader.php");

Loader::boot();