<?php

defined('ITAKEN_MX_ROOT') || exit('ERROR: Functions dose not included!');

/**
 * 本文件所设置方法仅供调试使用
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-06-05
 */

if (!function_exists('p')) {
    
    /**
     * 重写 p 输出
     *
     * @param mixed ...$args
     * @return void
     */
    function p(...$args)
    {
        dump($args);
    }
}

if (!function_exists('dump')) {

    /**
     * 重写 dump 输出
     *
     * @param mixed ...$args
     * @return void
     */
    function dump(...$args)
    {
        var_dump($args);
    }
}
