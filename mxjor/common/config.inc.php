<?php

defined('ITAKEN_MX_ROOT') || exit('ERROR: Framework config unable loaded!');

/**
 * 获取配置
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-20
 */
$config = [
    'DB_TYPE' => '',
    'DB_NAME' => '',
    'DB_HOST' => '',
    'DB_PORT' => '',
    'DB_USER' => '',
    'DB_PASSWD' => '',
    'TBL_PREFIX' => '',
    'TBL_SUFFIX' => '',
];

// 获取用户配置
$userConfig = [];
$userConfigFile = ITAKEN_MX_ROOT . '/app/config/default.inc.php';
if(file_exists($userConfigFile)){
    $userConfig = include($userConfigFile) ?: [];
}

// 返回配置
$mxConfig = array_merge($config, $userConfig);
$GLOBALS['_MX_CONFIG'] = $mxConfig;

return $mxConfig;
