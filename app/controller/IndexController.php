<?php

namespace app\controller;

use mxjor\library\Controller;
use app\model\index\IndexModel;

/**
 * 主目录
 */
class IndexController extends Controller
{
    /**
     * 主页
     */
    public function actionIndex()
    {
        $this->assign('title', 'Hello World!');
        $this->assign(['name' => 'mxPHP']);
        $this->display();
    }

    /**
     * 调试
     *
     * @return void
     */
    public function actionTest()
    {
        p(__METHOD__, (new IndexModel)->test());
    }
}
