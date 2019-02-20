<?php

/**
 * 公共方法
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */
defined('ITAKEN_MX_ROOT') || exit('ERROR: functions not included!');

 /**
  * 重写输出
  *
  * @param mixed ...$args
  * @return void
  */
function p(...$args)
{
    foreach ($args as $arg) {
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
