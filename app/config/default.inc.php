<?php

defined('ITAKEN_MX_ROOT') || exit('ERROR: default config unable loaded');

/**
 * 配置文件
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-20
 */

return [
    // 数据库连接
    'DB_TYPE' => 'mysqli',
    'DB_NAME' => 'mysql',
    'DB_HOST' => 'localhost',
    'DB_PORT' => '3306',
    'DB_USER' => 'mxPHP',
    'DB_PASSWD' => '',
    'TBL_PREFIX' => '', // 表前缀
    'TBL_SUFFIX' => '_tbl', // 表后缀
    'TBL_SPLIT' => '_', // 表名称分割符

    // TODO::Mongo 连接

    // TODO::redis 连接

    // TODO::memcache 连接

];
