<?php

/**
 * 公共模型,model里面的所有模型均继承它,用来使用db和mem的入口
 * Yimiao
 * 2013-12-20
 */
class Core_Model {

    private $objDb;
    private $objMem;

    public function __get($name) {

        if (substr($name, 0, 2) === 'db') {
            $key = strtolower(substr($name, 2));
            $this->objDb[$key] = new Mysql_Class($key);
            return $this->objDb[$key];
        }

        if (substr($name, 0, 3) === 'mem') {
            $key = strtolower(substr($name, 3));
            $this->objMem[$key] = new Memcache_Class($key);
            return $this->objMem[$key];
        }
    }

    public function __construct() {
        $this->init();
    }

    public function init() {
        
    }

}
