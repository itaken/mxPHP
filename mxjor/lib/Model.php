<?php

namespace mxjor\lib;

use \mxjor\utility\Mxdoo;

/**
 * 模型 原始类
 *
 * @author itaken <regelhh@gmail.com>
 * @since 2019-02-19
 */
abstract class Model extends Mxdoo
{
    /**
     * 初始化
     */
    public function __construct(){
        $modelEpl = explode('\\', static::class);  // 分割调用类
        $curModel = str_replace('model', '', strtolower(end($modelEpl)));
        // 组装 表名称
        $this->tblName = \config('TBL_PREFIX') . $curModel . \config('TBL_SUFFIX');

        parent::__construct();
    }
}
