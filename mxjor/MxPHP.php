<?php

namespace mxjor;

defined('ITAKEN_MX_ROOT') || define('ITAKEN_MX_ROOT', dirname(__DIR__) . '/');

/**
 * 框架
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */

class MxPHP
{
    /**
     * @var array 类库
     */
    private static $classMap = [];

    /**
     * @var string 模块
     */
    private static $module = null;

    /**
     * 启动入口
     *
     * @param string $module 模块
     */
    public static function run(string $module = 'app')
    {
        self::mxWhoops();   // 加载错误调试库
        
        self::$module = $module;

        self::mxDefine();   // 定义常量
        self::mxLoad();     // 自动加载
        self::mxRequire();  // 引入文件

        // 加载路由
        (new \mxjor\routes\Route($module))->load();
    }

    /**
     * 注册 whoops
     * @see https://github.com/filp/whoops
     *
     * @return void
     */
    private static function mxWhoops(): void
    {
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
    }

    /**
     * 定义 常量
     *
     * @return void
     */
    private static function mxDefine(): void
    {
        // 调试
        \defined('ITAKEN_MX_DEBUG') || define('ITAKEN_MX_DEBUG', false);
        // 框架目录
        \define('ITAKEN_MX_DIR', ITAKEN_MX_ROOT . 'mxjor/');
        // TWIG 模板目录
        \define('ITAKEN_MX_TPL', ITAKEN_MX_ROOT . self::$module . '/views/');
        // TWIG 缓存目录
        \define('ITAKEN_MX_CACHE', ITAKEN_MX_ROOT . self::$module . '/cache/');
    }

    /**
     * 加载文件
     *
     * @return void
     */
    private static function mxRequire(): void
    {
        // 公共方法
        require(ITAKEN_MX_DIR . 'common/function.inc.php');
        // 路由
        require(ITAKEN_MX_DIR . 'routes/Route.php');
        // 获取配置
        require(ITAKEN_MX_DIR . 'common/config.inc.php');
    }

    /**
     * 加载类库
     *
     * @return void
     */
    private static function mxLoad():void
    {
        $classMap = self::$classMap;
        \spl_autoload_register(function ($name) use (&$classMap) {
            if (!isset($classMap[$name])) {
                $class = str_replace('\\', '/', $name);
                $file = ITAKEN_MX_ROOT . $class . '.php';
                if (file_exists($file)) {
                    include($file);
                    $classMap[$name] = $file;
                }
            }
        });
    }
}
