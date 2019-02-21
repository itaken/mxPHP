<?php

namespace app\model\index;

use \app\model\BaseModel;

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
     * 初始化
     */
    public function __construct()
    {
        parent::__construct();

        // $res = $this->insert([
        //     'url' => 'https://www.baidu.com',
        //     'hosted' => 'www.baidu.com',
        //     'title' => 'baidu',
        //     'add_time' => time(),
        // ]);
        // $res = $this->update(['url' => 'www.baidu.com'], ['id' => 1]);
        // $res = $this->delete(['id' => 2]);
        // $res = $this->getRow(['id' => 1]);
        $res = $this->getList(['id' => ['>=' => 100]], '*', 'id DESC', '0,10');
        p($res, $this->getLastSql(), $this->getQueryError());
    }
}
