<?php

/*
 * 登录公共控制器，主要进行登录和权限控制
 * yimiao @ 4014-03-05
 */

class Default_Common_Controllers extends Core_Controller {

    const NOLOGIN = 0; //没登录
    const OVERTIME = 1; //登录超时
    const NOPREMISS = 2; //没权限
    const NONEEDLOGIN = 3; //不需要登录
    const LOGIN = 4; //已经登录

    public function checkLogin() {
        $controllerName = Core_Init::getControllerName();
        $actionName = Core_Init::getActionName();
        if ($controllerName == 'Index') {
            if ($actionName == 'Login' || $actionName == 'Loginout') {
                return self::NONEEDLOGIN;
            }
        }
        if (!$_SESSION['user']['uid']) {
            return self::NOLOGIN;
        }
        if (!$this->checkLoginTime($_SESSION['user']['ontime'])) {
            return self::OVERTIME;
        }
        if (!$this->checkPremission($_SESSION['user']['premissionStr'])) {
            return self::NOPREMISS;
        }
        return self::LOGIN;
    }

    /*
     * 检查超时
     */

    public function checkLoginTime($time) {
        $nowtime = mktime();
        if ($nowtime - $time > 3600) {
            return false;
        }
        return true;
    }

    /**
     * 分发结束前调用
     * @param 
     * @return void
     */
    public function init() {
        $status = $this->checkLogin();
        switch ($status) {
            case self::NOLOGIN:
                $this->showMessage("后台管理操作，请先登录！", Core_Init::seturl(array('_m' => 'default', '_c' => 'index', '_a' => 'login')), 1);
                break;
            case self::OVERTIME:
                $this->showMessage("登录已超时，请重新登录！", Core_Init::seturl(array('_m' => 'default', '_c' => 'index', '_a' => 'login')), 1);
                break;
            case self::NOPREMISS:
                $this->showMessage("您的权限不够哦！", "", 999999);
                exit;
                break;
            case self::NONEEDLOGIN:
                break;
            case self::LOGIN:
                $_SESSION['user']['ontime'] = time();
                $this->out['userInfo'] = $_SESSION['user'];
                break;
        }
    }

    /**
     * 判断权限
     * @param type $rid
     * @return boolean 
     */
    public function checkPremission($premissionStr) {
        if ($premissionStr == "ALL") {
            return true;
        }

        $mainName = Core_Init::getMainName();
        if ($mainName == 'Active' || $mainName == 'Default') {//首页和广告活动不进行权限验证!
            return true;
        }
        $premissionArr = json_decode($premissionStr, TRUE);
        if ($premissionArr[Core_Init::getMainName()][Core_Init::getControllerName()][Core_Init::getActionName()] == 1) {
            return true;
        }
        return false;
    }

    /**
     * 对话框
     * @param 
     * @return void
     */
    public function showMessage($message, $urlForward = '', $second = 1) {
        $message = '<a  href="' . $urlForward . '">' . $message . '</a>';
        $this->_smarty->assign('message', $message);
        $this->_smarty->assign('pageTitle', '消息中心');
        $this->_smarty->assign('urlForward', $urlForward);
        $this->_smarty->assign('second', $second);
        $this->_smarty->display('Default/showmessage.html');
        exit;
    }

}
