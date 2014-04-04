<?php

/* * *
 * 初始化注册类文件
 * Yimiao
 * 2014-03-04
 */

class Core_Registry {

    /**
     * 自身对象
     *
     */
    protected static $_instance = null;

    /*
     * 实例化自身
     *
     */

    public static function instance() {
        if (null == self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     *
     * 注册自动加载函数
     */
    public static function register() {
        spl_autoload_register(array(self::instance(), 'autoload'));
    }

    /*
     *
     * 自动加载类
     */

    public function autoload($class) {
        if (class_exists($class, false) || interface_exists($class, false)) {
            return;
        }
        $className = ltrim($class, '\\');
        $file = '';
        $namespace = '';
        if ($lastNsPos = strripos($className, '\\')) {
            $namespace = substr($className, 0, $lastNsPos);
            $className = substr($className, $lastNsPos + 1);
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
        }
        if (strpos($class, 'Core') !== false) {
            $file .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        } else if (strpos($class, 'Controllers') !== false) {
            $fileArr = explode('_', $class);
            $file.=$fileArr[0] . '/' . 'Controllers/' . $fileArr[1] . '.php';
        } else if (strpos($class, 'Model') !== false) {
            $fileArr = explode('_', $class);
            $file.=$fileArr[0] . '/' . 'Models/' . $fileArr[1] . '.php';
        } else {
            $file .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        }
        return include $file;
    }

}
