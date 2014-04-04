<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Core_Front {

    protected static $_instance = null;
    private static $_request = null;

    public static function getInstance() {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function __get($name) {
        if ($name === '_request') {
            if (self::$_request === null) {
                self::$_request = new Core_Request_Abstract();
            }
            return self::$_request;
        }
    }

}
