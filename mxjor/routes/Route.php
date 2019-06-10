<?php

namespace mxjor\routes;

use mxjor\MxPHP;
use mxjor\exception\MxException;

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
     * @var string 层级目录
     */
    private $catalog = '';

    /**
     * @var string 控制器
     */
    private $controller = 'index';

    /**
     * @var string 方法
     */
    private $action = 'index';

    /**
     * 构造器
     *
     * @param string $module
     * @return void
     */
    public function __construct(string $module)
    {
        // 模块
        $this->module = $module ?: 'app';

        // 解析 路由
        $uri = filter_input(INPUT_SERVER, 'REQUEST_URI') ?: $_SERVER['REQUEST_URI'];
        $uri = strpos($uri, '?') !== false ? strstr($uri, '?', true) : $uri;
        $pathsArr = trim($uri, '/') ? \explode('/', trim($uri, '/')) : [];
        $pathNum = count($pathsArr);
        $catalogArr = [];
        $controller = $action = '';
        for ($i = 0; $i < $pathNum; $i ++) {
            $_name = \strtolower(trim($pathsArr[$i]));
            if (!\preg_match('/[a-zA-z]+(\w-)*/', $_name)) {
                throw new \Exception('没有该页面!', 404);
            }
            if ($i == $pathNum - 1) {
                $action = $_name;
                continue;
            } elseif ($i == $pathNum -2) {
                $controller = $_name;
                continue;
            }
            $catalogArr[] = $_name;
        }
        $catalogArr && $this->catalog = implode('\\', $catalogArr);
        $controller && $this->controller = $action ? $controller : $action;
        $action && $this->action = $action;
    }

    /**
     * 加载路由
     *
     * @return mixed
     */
    public function load()
    {
        $module = $this->module;
        $catalog = $this->catalog;
        $controller = $this->controller;
        $action = $this->action;
        
        // 组装 命名空间
        $namespace = "{$module}\controller\\{$catalog}";
        
        // 组装 完整类名
        $controllerName = \ucfirst($controller);
        $controllerPath = "{$namespace}\\{$controllerName}Controller";
        $controllerClass = \str_replace('\\\\', '\\', $controllerPath);
        
        // 组装 方法名
        $actionName = 'action' . \ucfirst($action); // 方法名称

        // 判断是否有该方法
        if (!method_exists($controllerClass, $actionName)) {
            throw new MxException('没有该页面', 404);
        }
        
        // 作用域参数回传
        MxPHP::setScopeParams([
            'module' => $module,
            'controller' => $controllerClass,
            'action' => $actionName,
            'viewPath' => "{$catalog}/{$controller}/{$action}",
        ]);

        // 调起类方法
        return \call_user_func([new $controllerClass, $actionName]);
    }

}
