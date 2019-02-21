<?php

namespace app\controller;

use \mxjor\lib\Controller;
use app\model\index\IndexModel;
use app\model\index\UrlModel;

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
        $this->assign('name', 'Hello World!');
        $this->display();
    }

    public function actionTest()
    {
        p(new IndexModel);
        p(new IndexModel);
        p(new IndexModel);
        p(new UrlModel);
    }
}
