<?php

namespace mxjor\library;

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
     * @var array 类集
     */
    private static $mxClassMap = [];

    /**
     * 初始化
     */
    public function __construct()
    {
        $clsName = static::class;
        if (!isset(self::$mxClassMap[$clsName])) {
            $this->genTblName($clsName);
        } else {
            $this->tblName = self::$mxClassMap[$clsName];
        }
        parent::__construct();
    }

    /**
     * 生成 表明
     *
     * @param string $clsName
     * @return void
     */
    private function genTblName(string $clsName): void
    {
        if (empty($this->tblName)) {
            $modelEpl = explode('\\', $clsName);  // 分割调用类
            if ('_' === config('TBL_SPLIT')) {
                $modelSplit = preg_split('/(?=[A-Z])/', end($modelEpl));
                $tblNameArr = [];
                foreach ($modelSplit as $split) {
                    if (empty($split) || in_array($split, ['model', 'Model'])) {
                        continue;
                    }
                    $tblNameArr[] = strtolower($split);
                }
                $tblName = implode('_', $tblNameArr);
            } else {
                $tblName = str_replace('Model', '', end($modelEpl));
            }
            // 组装 表名称
            $this->tblName = \config('TBL_PREFIX') . $tblName . \config('TBL_SUFFIX');
        }
        self::$mxClassMap[$clsName] = $this->tblName;
    }
}
