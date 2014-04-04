<?php

/**
 * 数据库操作基础类，不允许入口文件、模型、控制器直接调用
 * Yimiao
 * 2013-12-20
 */
class Mysql_Class {

    private static $conn = array();
    private $_db;
    private $_dbConf;
    private $_connLink;

    public function __construct($db) {
        $this->_db = $db;
        $allDbConf = Core_Init::getConf('Conf_Mysql');
        $this->_dbConf = $allDbConf[$this->_db];
        $this->_connLink = $this->connect();
    }

    private function connect() {
        if (empty(self::$conn[$this->_db])) {
            self::$conn[$this->_db] = mysql_connect($this->_dbConf['host'], $this->_dbConf['user'], $this->_dbConf['passwd']);
            if (self::$conn[$this->_db] === false) {
                $errorText = "\r\n数据库连接错误:\r\nhost:{$this->_dbConf['host']}\r\nuser:{$this->_dbConf['user']}\r\npasswd:{$this->_dbConf['passwd']}";
                errorLog($errorText);
            }
            if ($this->_dbConf['db']) {
                mysql_select_db($this->_dbConf['db'], self::$conn[$this->_db]);
            }
            mysql_query("SET NAMES UTF8");
        }
        return self::$conn[$this->_db];
    }

    public function query($sql) {
        $query = mysql_query($sql, $this->_connLink);
        if ($query === false) {
            $errorText = "\r\n错误SQL语句:\r\n{$sql}";
            errorLog($errorText);
        }
        return $query;
    }

    public function getAll($sql) {
        $res = $this->query($sql);
        if ($res !== false) {
            $arr = array();
            while ($row = mysql_fetch_assoc($res)) {
                $arr[] = $row;
            }
            return $arr;
        } else {
            return false;
        }
    }

    public function insert_id() {
        return mysql_insert_id();
    }

    public function getOne($sql, $limited = false) {
        if ($limited == true) {
            $sql = trim($sql . ' LIMIT 1');
        }
        $res = $this->query($sql);
        if ($res !== false) {
            $row = mysql_fetch_assoc($res);
            if ($row !== false) {
                return $row;
            } else {
                return '';
            }
        } else {
            return false;
        }
    }

    /**
     * 
     * @param type $table
     * @param type $updateArr
     * @param type $where
     * @return type
     * 更新数据
     */
    public function updateTable($table, $updateArr, $where) {
        $formatSql = $this->insertUpdateSqlFormat($updateArr);
        $sql = "update {$table} {$formatSql} {$where}";
        $result = $this->query($sql);
        return $result;
    }

    /**
     * 
     * @param type $table
     * @param type $array
     * @return type
     * 插入数据
     */
    public function insertIntoTable($table, $array) {
        $formatSql = $this->insertUpdateSqlFormat($array);
        $sql = "insert into {$table} {$formatSql}";
        $result = $this->query($sql);
        return $result;
    }

    /**
     * 
     * @param type $array
     * @return type
     * 插入更新sql格式化
     */
    private function insertUpdateSqlFormat($array) {
        foreach ($array as $key => $value) {
            $setArr[] = "`{$key}`='{$value}'";
        }
        $set = implode(',', $setArr);
        $sql = "SET {$set}";
        return $sql;
    }

    public function closeLink() {
        mysql_close($this->_connLink);
        unset(self::$conn[$this->_db]);
    }

}
