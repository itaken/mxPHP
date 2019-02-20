<?php

namespace app\controller;

use \mxjor\lib\Controller;

/**
 * 主目录
 *
 * @author itaken <regelhh@gmail.com>
 * @since 2019-02-20
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
}
