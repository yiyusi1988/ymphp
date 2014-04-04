<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Core_Controller {

    public $_outType = 'smarty';   // smarty json ajax
    public $_smarty;
    public $tpl = null;  // index.tpl
    public $out = null;
    public $timeStart = 0;
    public $_m, $_c, $_a, $_cTitle, $_aTitle;

    public function __construct() {
        $smartyConf = Core_Init::getConf('Conf_Smarty');
        $this->_smarty = Core_Smarty::getSmarty($smartyConf);
        $this->init();
    }

    /**
     * Display
     * @param mix $data 如果
     * @param mix $outType
     */
    public function display() {
        $this->preDispatch();
        if ($this->_outType === 'smarty') {
            if ($this->tpl === null) {
                $this->tpl = $this->_m . '/' . $this->_c . '/' . strtolower($this->_a) . '.html';
            }
            if ($this->out !== null) {
                foreach ($this->out as $key => $value) {
                    $this->_smarty->assign($key, $value);
                }
            }
            $this->_smarty->assign('pageTitle', $this->_aTitle . '_' . $this->_cTitle);
            $this->_smarty->assign('_mainName', $this->_m);
            $this->_smarty->assign('_controllerName', $this->_c);
            $this->_smarty->assign('_actionName', $this->_a);
            $this->_smarty->display($this->tpl);
        }
    }

    public function __call($name, $arguments) {
        errorLog('找不到' . $this->_m . '_' . $this->_c . '类中的该方法:' . $name);
    }

    public function __get($name) {
        if ($name === '_request') {
            return new Core_Request_Abstract();
        }
    }

    /**
     * 初始化
     */
    public function init() {
        
    }

    /**
     * 分发前调用
     */
    public function preDispatch() {
        
    }

}
