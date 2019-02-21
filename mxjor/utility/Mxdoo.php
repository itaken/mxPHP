<?php

namespace mxjor\utility;

use \Medoo\Medoo;

/**
 * 数据库 工具类
 *
 * @author itaken <regelhh@gmail.com>
 * @since 2019-02-20
 */

class Mxdoo
{

    /**
     * @var string 数据库
     */
    protected $dbName = null;

    /**
     * @var string 数据表
     */
    protected $tblName = null;

    /**
     * @var object 数据库操作对象
     */
    private $mxMedoo;

    /**
     * @var array 数据库配置
     */
    private $mxMedooConfig = [];

    /**
     * @var array 数据库操作对象集合
     */
    private static $mxMedooMap = [];

    /**
     * 初始化
     */
    public function __construct()
    {
        $dbConfig = config(null);  // 获取配置
        $dbName = $this->dbName ?: $dbConfig['DB_NAME'];  // 数据库名称
        $this->dbName = $dbName;
        
        // 初始化对象
        if (!isset(self::$mxMedooMap[$dbName])) {
            // 组装配置项
            $this->packDbConfig($dbConfig);
            // 构建对象
            self::$mxMedooMap[$dbName]  = (new Medoo($this->mxMedooConfig));
        }

        $this->mxMedoo = self::$mxMedooMap[$dbName]; // medoo 对象
    }

    /**
     * 初始化连接对象
     *
     * @param array $dbConfig
     * @return void
     */
    public function packDbConfig(array $dbConfig): void
    {
        if (!empty($dbConfig)) {
            $dbName = $this->dbName;
            if ($dbConfig['DB_TYPE'] && $dbName && $dbConfig['DB_USER']) {
                $this->mxMedooConfig = [
                    'database_type' => in_array($dbConfig['DB_TYPE'], ['mysql', 'mysqli']) ? 'mysql' : $dbConfig['DB_TYPE'],
                    'database_name' => $dbName,
                    'server' => $dbConfig['DB_HOST'] ?: 'localhost',
                    'port' => $dbConfig['DB_PORT'] ?: 3306,
                    'username' => $dbConfig['DB_USER'],
                    'password' => $dbConfig['DB_PASSWD'] ?: '',
                ];
            }
        }
    }

    /**
     * 获取操作对象
     *
     * @return object
     */
    private function getMedoo()
    {
        $medoo = $this->mxMedoo;
        if (empty($medoo)) {
            throw new \Exception('Medoo object not found!');
        }
        return $medoo;
    }

    /**
     * 插入数据
     *
     * @param array $data
     * @return integer
     */
    public function insert(array $data): int
    {
        if (empty($data)) {
            return 0;
        }
        $this->getMedoo()->insert($this->tblName, $data);
        return $this->getMedoo()->id();
    }
}
