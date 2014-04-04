<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Core_Request_Abstract {

    private $_mgc;

    public function __construct() {
        $this->_mgc = get_magic_quotes_gpc();
    }

    public function getParams() {
        $post = $_POST;
        foreach ($_GET as $key => $value) {
            if ($post[$key]) {
                continue;
            }
            $post[$key] = $value;
        }
        return $this->_getParam($post);
    }

    public function getParam($key) {
        $value = $_POST[$key] ? $_POST[$key] : $_GET[$key];
        return $this->_getParam($value);
    }

    private function _getParam($var) {
        if (!is_array($var)) {
            if (!$this->_mgc) {
                $var = addslashes($var);
            }
            $_tmp = htmlspecialchars(trim($var));
        } else {
            foreach ($var as $k => $v) {
                $_tmp[$k] = $this->_getParam($v);
            }
        }
        return $_tmp;
    }

}
