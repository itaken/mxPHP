<?php

namespace mxjor\library;

use mxjor\MxPHP;

/**
 * 控制器 原始类
 *
 * @author itaken <regelhh@gmail.com>
 * @since 2019-02-19
 */
abstract class Controller
{

    /**
     * @var array 输入数据
     */
    protected $input = [];

    /**
     * @var array 数据
     */
    private $mxData = [];

    /**
     * @var object Twig
     */
    private $mxTwig;

    /**
     * 初始化
     */
    public function __construct(...$args)
    {
        // 加载模板引擎
        $loader = new \Twig\Loader\FilesystemLoader(ITAKEN_MX_TPL);
        $this->mxTwig = new \Twig\Environment($loader, [
            // 'cache' => ITAKEN_MX_CACHE,  // 缓存
            'debug' => ITAKEN_MX_DEBUG,  // 调试选项
        ]);
        // 合并输入数据
        $this->input = array_merge($_REQUEST, $_GET, $_POST);
    }

    /**
     * 视图 数据收集
     *
     * @param string $name
     * @param mixed $data
     * @return void
     */
    protected function assign(string $name, $data): void
    {
        $this->mxData[$name] = $data;
    }

    /**
     * 输出视图
     * @see https://github.com/twigphp/Twig
     *
     * @param string $file
     * @return void
     */
    protected function display(string $file = ''): void
    {
        if (empty($file)) {
            $params = MxPHP::getScopeParams();  // 作用域
            $file = $params['viewPath'] . '.html';
        } elseif (strrpos($file, '.html') !== 0) {
            $file .= '.html';
        }
        $this->mxTwig->display($file, $this->mxData);  // 输出模板
        $this->mxData = [];  // 清空数据
    }
}
