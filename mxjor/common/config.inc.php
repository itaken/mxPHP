<?php

defined('ITAKEN_MX_MODULE') || exit('ERROR: Framework config unable loaded!');

use mxjor\MxPHP;

/**
 * 获取配置
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-20
 */
$config = [
    // 数据库
    'DB_TYPE' => '',
    'DB_NAME' => '',
    'DB_HOST' => '',
    'DB_PORT' => '',
    'DB_USER' => '',
    'DB_PASSWD' => '',
    // 数据表
    'TBL_PREFIX' => '', // 表前缀
    'TBL_SUFFIX' => '', // 表后缀
    'TBL_SPLIT' => '',  // 表名称分割符(为空,则使用驼峰)
    // 模板
    'TPL_ROOT' => ITAKEN_MX_TPL,   // 模板路径
    'TPL_SUFFIX' => '.html', // 模板后缀
];

// 获取用户配置
$userConfig = [];
$userConfigFile = ITAKEN_MX_MODULE . 'config/default.inc.php';
if (file_exists($userConfigFile)) {
    $userConfig = include($userConfigFile) ?: [];
}

// 返回配置
MxPHP::config(array_merge($config, $userConfig));
