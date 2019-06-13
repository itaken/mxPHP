<?php

/**
 * 主入口
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */

define('ITAKEN_MX_DEBUG', true);                    // 开启调试
define('ITAKEN_MX_ROOT', dirname(__DIR__) . '/');   // 定义主目录

require(ITAKEN_MX_ROOT . 'mxjor/MxPHP.php');        // 引入框架
require(ITAKEN_MX_ROOT . 'vendor/autoload.php');    // 加载composer包

\mxjor\MxPHP::run('app');
