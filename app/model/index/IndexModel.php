<?php

namespace app\model\index;

use app\model\BaseModel;

/**
 * 示例模型
 */
class IndexModel extends BaseModel
{
    /**
     * @var string 表名(选填)
     */
    protected $tblName = 'urls_tbl';

    /**
     * 测试
     *
     * @return void
     */
    public function test()
    {
        // 新增
        // $res = $this->insert([
        //     'url' => 'https://www.baidu.com',
        //     'hosted' => 'www.baidu.com',
        //     'title' => 'baidu',
        //     'add_time' => time(),
        // ]);
        // 更新
        // $res = $this->update(['url' => 'www.baidu.com'], ['id' => 1]);
        // 删除
        // $res = $this->delete(['id' => 2]);
        // 获取一条
        // $res = $this->getRow(['id' => 1]);
        // 获取列表
        $res = $this->getList(['id' => ['>=' => 100]], '*', 'id DESC', '0,10');
        // 获取最后一条
        // $res = $this->getLastSql();
        p($res, $this->getQueryError());
    }
}
