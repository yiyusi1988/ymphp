<?php

/*
 * 应用层 User 操作模型类
 * Yimiao @2014-03-05
 */

class Default_User_Models extends Core_Model {

    private $_userDbMod, $_areaMod;
    private $_userInfo, $_companyInfo;

    public function init() {
        $this->_userDbMod = new Default_UserDb_Models();
        $this->_areaMod = new Account_Area_Models();
        
    }

    public function getUserInfoByUsername($username) {
        $result = $this->_userDbMod->getUserInfoByUsername($username);
        return $result;
    }

    public function getUserInfoById($id) {
        if (empty($this->_userInfo[$id])) {
            $result = $this->_userDbMod->getUserInfoById($id);
            $companyInfo = $this->getCompanyInfo($result['cid']);
            unset($companyInfo['id']);
            foreach ($companyInfo as $key => $value) {
                $value = $value != '0' ? $value : '';
                $result[$key] = $value;
            }
            $result['premissionArr']=  json_decode($result['premissionStr'],true);
            $result['provinceCn'] = $this->getProvinceCn($companyInfo['province']);
            $result['companyTypeCn'] = getClassifyNameById($result['companyType']);
            if ($result['companyPhone']) {
                $companyPhoneArr = explode('-', $result['companyPhone']);
                $result['companyPhone_area'] = $companyPhoneArr[0];
                $result['companyPhone_board'] = $companyPhoneArr[1];
                $result['companyPhone_extension'] = $companyPhoneArr[2];
            }
            $this->_userInfo[$id] = $result;
        }

        return $this->_userInfo[$id];
    }

    public function getProvinceCn($pid) {
        if (!$pid) {
            return FALSE;
        }
        $return = $this->_areaMod->getProvinceCnById($pid);
        return $return;
    }

    public function getUserPermission($rid) {
        return 'ALL';
    }

    public function getCompanyInfo($cid) {
        if (empty($this->_companyInfo[$cid])) {
            $return = $this->_userDbMod->getCompanyInfo($cid);
            $this->_companyInfo[$cid] = $return;
        }
        return $this->_companyInfo[$cid];
    }

    public function getCompanyCash($cid) {
        $return = $this->getCompanyInfo($cid);
        return $return['cash'];
    }

    public function getCompanyInfoByUid($uid) {
        $useInfo = $this->getUserInfoById($uid);
        $companyInfo = $this->getCompanyInfo($useInfo['cid']);
        return $companyInfo;
    }

    public function getAllPage() {
        return 'AllPage';
    }

    public function updateLastLoginTime($id) {
        $result = $this->_userDbMod->updateLastLoginTime($id);
        return $result;
    }

    public function updateUserInfo($array, $uid) {
        $result = $this->_userDbMod->updateUserInfo($array, $uid);
        return $result;
    }

    public function updateCompanyInfo($array, $id) {
        $result = $this->_userDbMod->updateCompanyInfo($array, $id);
        return $result;
    }
    
    public function getUserCount($where){
        $result=  $this->_userDbMod->getUserCount($where);
        return $result;
    }
    
    public function getUserList($limit, $offset, $where){
        $return=array();
        $result=  $this->_userDbMod->getUserList($limit, $offset, $where);
        if(!empty($result)){
            $paramsConf=  Core_Init::getConf('conf_Params');
            foreach($result as $value){
                $value['statusCn']=$paramsConf['userStatus'][$value['status']];
                $return[]=$value;
            }
        }
        return $return;
    }

}
