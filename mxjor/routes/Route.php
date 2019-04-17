<?php

namespace mxjor\routes;

/**
 * 路由类
 *
 * @author itaken<regelhh@gmail.com>
 * @since 2019-02-19
 */

class Route
{
    /**
     * @var string 模块
     */
    private $module;

    /**
     * @var string 控制器
     */
    private $controller;

    /**
     * @var string 方法
     */
    private $action;

    /**
     * 构造器
     *
     * @param string $module
     */
    public function __construct(string $module)
    {
        // 模块
        $this->module = $module ?: 'app';
        // 解析 路由
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI') ?: $_SERVER['REQUEST_URI'];
        $paths = $uri ? \explode('/', trim($uri, '/')) : [];
        $controller = !empty($paths[0]) ? \strtolower(trim($paths[0])) : 'index';
        $action = !empty($paths[1]) ? strtolower(trim($paths[1])) : 'index';
        $this->controller = $controller;
        $this->action = $action;
        
        // 全局变量
        $GLOBALS['_controller'] = $controller;
        $GLOBALS['_action'] = $action;

        // 解析参数
        $num = count($paths);
        if ($num > 2) {
            for ($i =2; $i < $num; $i +=2) {
                if (!isset($paths[$i + 1])) {
                    continue;
                }
                $name = $paths[$i];
                if (empty($name) || is_numeric($name)) {
                    continue;
                }
                $value = $paths[$i + 1];
                $_GET[$name] = $value;
            }
        }
    }

    /**
     * 加载路由
     *
     * @return void
     */
    public function load(): void
    {
        $module = $this->module;
        $controller = $this->controller;
        $action = $this->action;
        $controllerName = \ucfirst($controller);
        $controllerClass = "\\{$module}\controller\\{$controllerName}Controller";   // 完整类名
        $controllerFile = ITAKEN_MX_ROOT . str_replace('\\', '/', $controllerClass) . '.php';
        if (file_exists($controllerFile)) {
            include($controllerFile);
            $actionName = 'action' . \ucfirst($action); // 方法名称
            (new $controllerClass)->$actionName();
        }
    }
}
