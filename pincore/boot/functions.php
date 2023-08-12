<?php

/**

 * @author   Webraak
 * @link https://www.webraak.com/
 * @license  https://opensource.org/licenses/MIT MIT License
 */

use webraak\component\app\AppProvider;
use webraak\component\Config;
use webraak\component\Dir;
use webraak\component\Dump;
use webraak\component\Lang;
use webraak\component\Service;
use webraak\component\Url;
use webraak\component\HelperString;

function url($link = null)
{
    return Url::link($link);
}

function furl($path = null)
{
    return Url::file($path);
}

function path($path = null, $app = null)
{
    return Dir::path($path, $app);
}

function lang($var)
{
    $args = func_get_args();
    $first = array_shift($args);

    $result = Lang::replace($first, $args);

    echo !is_array($result) ? $result : HelperString::encodeJson($result);
}

function rlang($var)
{
    $args = func_get_args();
    $first = array_shift($args);

    return Lang::replace($first, $args);
}

function config($key)
{
    $args = func_get_args();
    if (isset($args[1]))
        Config::set($key, $args[1]);
    else
        return Config::get($key);

    return null;
}

function service($service)
{
    return Service::run($service);
}

/**
 * Dumps information about a variable and exit
 * 
 * @param $data
 * @param string $label 
 */
function dd($data = null, $label = null)
{
    echo Dump::r($data, $label);
    exit;
}

/**
 * Dumps information about a variable
 * 
 * @param $data
 * @param string $label 
 */
function dump($data = null, string $label = null)
{
    echo Dump::r($data, $label);
}

function app($key)
{
    return AppProvider::get($key);
}
