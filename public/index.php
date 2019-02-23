<?php

/**
 * 主入口
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */
// ini_set('display_error', 'On');
define('ITAKEN_MX_DEBUG', true);
define('ITAKEN_MX_ROOT', dirname(__DIR__) . '/');
require(ITAKEN_MX_ROOT . 'vendor/autoload.php');
require(ITAKEN_MX_ROOT . 'mxjor/MxPHP.php');

\mxjor\MxPHP::run('app');
