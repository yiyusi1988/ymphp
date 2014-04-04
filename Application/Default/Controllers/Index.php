<?php

/*
 * dsp index控制器
 * Yimiao @ 2014-03-05
 */

class Default_Index_Controllers extends Default_Common_Controllers {

    private $_UserMod;

    public function init() {
        $this->_UserMod = new Default_User_Models();
        $this->_cTitle = '用户管理';
        parent::init();
    }

    public function Index() {
        $getPostTest = $this->_request->getParams(); //获取所有
        $getPostTesta = $this->_request->getParam('a'); //获取单个
        $mod = new Core_Model();
        $sql = "select * from test";
        $result = $mod->dbDsp->getAll($sql);
        $this->out['data'] = $result[0];
        $this->out['menu'] = $this->_m;
        $this->out['title'] = '首页';
    }

    public function Loginout() {
        session_destroy();
        $this->showMessage('退出登录成功！', Core_Init::seturl(array('_m' => 'default', '_c' => 'index', '_a' => 'login')));
    }

    public function Login() {
        $username = $this->_request->getParam('email');
        $password = $this->_request->getParam('passwd');
        if (!empty($username) && !empty($password)) {
            $return = $this->userLogin($username, $password);
            echo json_encode($return);
            exit;
        }
        $this->_aTitle = '登录';
    }

    public function Rtx() {
        $rtx = new Rtx_Class();
        $rtx->sendNotify('gz1129', '张继明测试', '继明测试');
        exit;
    }

    public function showsomething() {
        $this->showMessage('你好啊 消息', '/default/index/index/', 100);
    }

    /*
     * 登录判断
     */

    private function userLogin($username, $password) {
        $userinfo = $this->_UserMod->getUserInfoByUsername($username);
        $ps = $userinfo ? md5($username . '~)!(@*#&$^%' . $password) == $userinfo['passwd'] : FALSE;
        if ($ps) {
//            $rolestr = $this->_UserMod->getUserPermission($userinfo['rid']);//获取权限str
//            $allpage = $this->_UserMod->getAllPage();//获取所有页面
            $this->_UserMod->updateLastLoginTime($userinfo['id']);
            $_SESSION['user']['uid'] = $userinfo['id'];
            $_SESSION['user']['email'] = $userinfo['email'];
            $_SESSION['user']['premissionStr'] = $userinfo['premissionStr'];
            $_SESSION['user']['cid'] = $userinfo['cid'];
            $_SESSION['user']['ontime'] = mktime();
            $return = array('code' => '000', 'msg' => '恭喜您，登录成功！');
        } else {
            session_destroy();
            $return = array('code' => '001', 'msg' => '用户名或密码错误，请重新登录！');
        }
        return $return;
    }

    public function Regist() {
        /*
         * 待完成
         */
        $this->out['title'] = '注册';
    }

}
