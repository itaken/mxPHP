<?php

/**
 * 主入口
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */
ini_set('display_errors', 'On');
error_reporting(E_ALL);
define('ITAKEN_MX_DEBUG', false);    // 开启调试
define('ITAKEN_MX_ROOT', dirname(__DIR__) . '/');   // 定义主目录
require(ITAKEN_MX_ROOT . 'vendor/autoload.php');    // 加载composer包
require(ITAKEN_MX_ROOT . 'mxjor/MxPHP.php');        // 引入框架

\mxjor\MxPHP::run('app');
