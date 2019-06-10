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
        $dbConfig = MxPHP::config(null);  // 获取配置
        $dbName = $this->dbName ?: $dbConfig['DB_NAME'];  // 数据库名称
        $this->dbName = $dbName;
        
        // 初始化对象
        if (!empty($dbName)) {
            if (!isset(self::$mxMedooMap[$dbName])) {
                // 组装配置项
                $this->packDbConfig($dbConfig);
                p($this->mxMedooConfig);
                // 构建对象
                if ($this->mxMedooConfig) {
                    $this->mxMedoo = self::$mxMedooMap[$dbName]  = (new Medoo($this->mxMedooConfig));
                }
            } else {
                $this->mxMedoo = self::$mxMedooMap[$dbName]; // medoo 对象
            }
        }
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
            throw new \Exception('Medoo Unconnected Database!');
        }
        return $medoo;
    }

    /**
     * 组装 where 条件
     * @see https://medoo.in/api/where
     *
     * @param array $where
     * @return array
     */
    private function packWhere(array $where): array
    {
        $whereArr = [];
        if (empty($where)) {
            return $whereArr;
        }
        $keyMap = [
            'between' => '[<>]',
            'not between' => '[><]',
            '>' => '[>]',
            'gt' => '[>]',
            '>=' => '[>=]',
            'egt' => '[>=]',
            '<' => '[<]',
            'lt' => '[<]',
            '<=' => '[<=]',
            'elt' => '[<=]',
            'like' => '[~]',
            'no like' => '[!~]',
        ];
        foreach ($where as $name => $value) {
            if (\is_array($value)) {
                $key = trim(key($value));
                if (isset($keyMap[$key])) {
                    $sign = $keyMap[$key];  // 符号
                    $whereArr[$name . $sign] = $value[$key];
                } else {
                    $whereArr[$name] = $value;
                }
            }
        }
        return $whereArr ?: $where;
    }

    /**
     * 数据库基本信息
     *
     * @return array
     */
    protected function connInfo(): array
    {
        return $this->getMedoo()->info();
    }

    /**
     * 获取 最后执行的SQL
     *
     * @return string
     */
    protected function getLastSql(): string
    {
        return $this->getMedoo()->last();
    }

    /**
     * 获取错误信息
     *
     * @return array
     */
    protected function getQueryError(): array
    {
        $error = $this->getMedoo()->error();
        if (empty($error[1]) || empty($error[2])) {
            return [];
        }
        return [
            'code' => $error[1],
            'message' => $error[2],
        ];
    }

    /**
     * 插入数据
     * @see https://medoo.in/api/insert
     *
     * @param array $data
     * @return integer
     */
    protected function insert(array $data): int
    {
        if (empty($data)) {
            return 0;
        }
        $this->getMedoo()->insert($this->tblName, $data);
        return $this->getMedoo()->id();
    }

    /**
     * 更新数据
     * @see https://medoo.in/api/update
     *
     * @param array $data
     * @param array $where
     * @return integer
     */
    protected function update(array $data, array $where): int
    {
        $where = $this->packWhere($where);
        $res = $this->getMedoo()->update($this->tblName, $data, $where);
        return $res->rowCount();
    }

    /**
     * 删除数据
     * @see https://medoo.in/api/delete
     *
     * @param array $where
     * @return integer
     */
    protected function delete(array $where): int
    {
        $where = $this->packWhere($where);
        $res = $this->getMedoo()->delete($this->tblName, $where);
        return $res->rowCount();
    }

    /**
     * 获取一行
     * @see https://medoo.in/api/get
     *
     * @param array $where
     * @param string|array $fields
     * @return array
     */
    protected function getRow(array $where, $fields = '*'): array
    {
        $where = $this->packWhere($where);
        return $this->getMedoo()->get($this->tblName, $fields, $where);
    }

    /**
     * 获取列
     * @see https://medoo.in/api/select
     *
     * @param array $where
     * @param string $fields
     * @param string $orderBy
     * @param string $limit
     * @return array
     */
    protected function getList(array $where, $fields = '*', string $orderBy = '', string $limit = ''): array
    {
        $where = $this->packWhere($where);
        if ($orderBy) {  // 排序条件
            $orderByArr = [];
            $orderByRes = explode(',', str_replace('  ', ' ', trim($orderBy)));
            foreach ($orderByRes as $byStr) {
                list($name, $sort) = explode(' ', $byStr);
                $orderByArr[$name] = $sort ?: 'ASC';
            }
            if ($orderByArr) {
                $where['ORDER'] = $orderByArr;
            }
        }
        if ($limit) {  // 限制条件
            $limitArr = explode(',', str_replace(' ', '', $limit));
            if (isset($limitArr[1])) {
                $where['LIMIT'] = [
                    $limitArr[0],
                    $limitArr[1],
                ];
            } else {
                $where['LIMIT'] = $limitArr[0];
            }
        }
        return $this->getMedoo()->select($this->tblName, $fields, $where);
    }

    /**
     * 获取 总数
     * @see https://medoo.in/api/count
     *
     * @param array $where
     * @return integer
     */
    protected function getCount(array $where = []): int
    {
        $where = $this->packWhere($where);
        return $this->getMedoo()->count($this->tblName, $where);
    }

    /**
     * 计算 总数
     * @see https://medoo.in/api/sum
     *
     * @param string $field
     * @param array $where
     * @return integer
     */
    protected function getSum(string $field, array $where = []): int
    {
        $where = $this->packWhere($where);
        return $this->getMedoo()->sum($this->tblName, $field, $where);
    }

    /**
     * 计算 平均数
     * @see https://medoo.in/api/avg
     *
     * @param string $field
     * @param array $where
     * @return integer
     */
    protected function getAvg(string $field, array $where = []): int
    {
        $where = $this->packWhere($where);
        return $this->getMedoo()->avg($this->tblName, $field, $where);
    }
}
