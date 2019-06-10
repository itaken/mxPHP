<?php

namespace mxjor;

use mxjor\routes\Route;

defined('ITAKEN_MX_DEBUG') || define('ITAKEN_MX_DEBUG', false);
defined('ITAKEN_MX_ROOT') || define('ITAKEN_MX_ROOT', dirname(__DIR__) . '/');

/**
 * 框架主入口
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-17
 */

class MxPHP
{
    /**
     * @var string 模块
     */
    private static $module = null;
    
    /**
     * @var array 类库
     */
    private static $config = [];

    /**
     * @var array 类库
     */
    private static $classMap = [];

    /**
     * @var array 作用域参数
     */
    private static $scopeParams = [];

    /**
     * 启动入口
     *
     * @param string $module 模块
     * @return mixed
     */
    public static function run(string $module = 'app')
    {
        self::$module = $module;
        
        self::mxWhoops();   // 加载错误调试
        self::mxDefine();   // 定义常量
        self::mxLoad();     // 自动加载
        self::mxRequire();  // 引入文件
        self::mxHandler();  // 捕获异常
        
        // 加载路由
        return (new Route($module))->load();
    }

    /**
     * 注册 whoops
     * @see https://github.com/filp/whoops
     *
     * @return void
     */
    private static function mxWhoops(): void
    {
        if (true === ITAKEN_MX_DEBUG) { // 开启调试模式
            ini_set('display_errors', 'On');
            error_reporting(E_ALL);

            // 加载调试类库
            if (class_exists('Whoops\Run')) {
                $whoops = new \Whoops\Run;
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                $whoops->register();
            }
        }
    }

    /**
     * 定义 常量
     *
     * @return void
     */
    private static function mxDefine(): void
    {
        // 框架目录
        \define('ITAKEN_MX_DIR', ITAKEN_MX_ROOT . 'mxjor/');
        // 模块目录
        \define('ITAKEN_MX_MODULE', ITAKEN_MX_ROOT . self::$module . '/');
        // TWIG 模板目录
        \define('ITAKEN_MX_TPL', ITAKEN_MX_MODULE . 'views/');
        // TWIG 缓存目录
        \define('ITAKEN_MX_CACHE', ITAKEN_MX_MODULE . 'cache/');
    }

    /**
     * 加载文件
     *
     * @return void
     */
    private static function mxRequire(): void
    {
        // 获取配置
        require(ITAKEN_MX_DIR . 'common/config.inc.php');
        // 公共方法
        require(ITAKEN_MX_DIR . 'common/function.inc.php');
        // 路由
        require(ITAKEN_MX_DIR . 'routes/Route.php');
    }

    /**
     * 加载类库
     *
     * @return void
     */
    private static function mxLoad():void
    {
        $classMap = &self::$classMap;
        \spl_autoload_register(function ($name) use (&$classMap) {
            if (!isset($classMap[$name])) {
                $class = str_replace(['\\', '//'], '/', $name);
                $file = ITAKEN_MX_ROOT . $class . '.php';
                if (file_exists($file)) {
                    include($file);
                }
                $classMap[$name] = $file;
            }
        });
    }

    /**
     * 捕获异常
     *
     * @return void
     */
    private static function mxHandler(): void
    {
        \set_exception_handler(function ($e) {
            // TODO:: 异常页面
            echo $e->getMessage();
        });
    }

    /**
     * 获取 配置
     *
     * @param array
     * @return void
     */
    public static function setConfig(array $config): void
    {
        if (!empty($config)) {
            self::$config = array_merge(self::$config, $config);
        }
    }

    /**
     * 获取/设置 配置
     *
     * @param string $name
     * @param mixed $value
     * @return mixed
     */
    public static function config($name, $value = null)
    {
        $mxConfig = self::$config;
        if (is_null($name)) {
            return $mxConfig;
        }
        if (is_null($value)) {
            return isset($mxConfig[$name]) ? $mxConfig[$name] : null;
        }
        self::setConfig([$name => $value ]);
        return true;
    }

    /**
     * 获取 作用域参数
     *
     * @param array
     * @return void
     */
    public static function setScopeParams(array $scopeParams): void
    {
        if (!empty($scopeParams)) {
            self::$scopeParams = $scopeParams;
        }
    }

    /**
     * 获取 作用域参数
     *
     * @return array
     */
    public static function getScopeParams(): array
    {
        return self::$scopeParams ?: [];
    }
}
