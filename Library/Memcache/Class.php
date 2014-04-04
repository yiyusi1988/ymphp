<?php

/**
 * memcache基本操作类
 * 不允许入口文件、模型直接调用
 * Yimiao
 * 2013-12-20
 */
class Memcache_Class {

    private static $conn;
    private $memObj;
    private $memConf, $mem, $memcacheLink;

    public function __construct($mem) {
        $this->mem = $mem;
        $allMemConf = Core_Init::getConf('Conf_Memcache');
        $this->memConf = $allMemConf[$mem];
        $this->memcacheLink = $this->connect();
    }

    private function connect() {
        if (empty(self::$conn[$this->mem])) {
            self::$conn[$this->mem] = memcache_connect($this->memConf['host'], $this->memConf['port']);
            if (self::$conn[$this->mem] === false) {
                $errorText = "\r\nmemcache服务器连接错误:\r\nhost:{$this->memConf['host']}\r\nport:{$this->memConf['port']}";
                errorLog($errorText);
            }
        }
        return self::$conn[$this->mem];
    }

    public function set($key, $value, $timeout, $compress = false) {
        return $this->memcacheLink->set($key, $value, $compress, $timeout);
    }

    public function get($key) {
        return $this->memcacheLink->get($key);
    }

}
