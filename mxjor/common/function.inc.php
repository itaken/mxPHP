<?php

/**
 * 公共方法
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */
defined('ITAKEN_MX_ROOT') || exit('ERROR: Functions dose not included!');

 /**
  * 重写输出
  *
  * @param mixed ...$args
  * @return void
  */
function p(...$args)
{
    foreach ($args as $arg) {
        if (ITAKEN_MX_DEBUG) {
            // fix json-handle plugin bug
            if (empty($arg) && is_array($arg)) {
                var_dump($arg);
                continue;
            }
        }
        dump($arg);
    }
}

/**
 * 输出 $_SERVER 变量
 *
 * @return void
 */
function _ps()
{
    dump($_SERVER);
}

/**
 * 输出 输入变量
 *
 * @return void
 */
function _pi()
{
    dump(array_merge($_REQUEST, $_GET, $_POST));
}

/**
 * 获取/设置 配置
 *
 * @param string $name
 * @param mixed $value
 * @return mixed
 */
function config($name, $value = null)
{
    $mxConfig = $GLOBALS['_MX_CONFIG'];
    if (is_null($name)) {
        return $mxConfig;
    }
    if (is_null($value)) {
        return isset($mxConfig[$name]) ? $mxConfig[$name] : null;
    }
    $GLOBALS['_MX_CONFIG'][$name] = $value;
    return true;
}
