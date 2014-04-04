<?php

/*
 * 数据层 用户操作类
 * yimiao @ 2014-03-05
 */

class Default_UserDb_Models extends Core_Model {

    private $_tUser = 'dspadmin.user';
    private $_tCompany = 'dspadmin.company';

    /**
     * 
     * @param type $username
     * @return type 通过用户名即邮箱获取用户信息
     */
    public function getUserInfoByUsername($username) {
        $sql = "select * from {$this->_tUser} where email='{$username}'";
        $result = $this->dbDsp->getone($sql);
        return $result;
    }

    /**
     * 
     * @param type $id
     * @return type 根据用户id获取用户基本信息
     */
    public function getUserInfoById($id) {
        $sql = "select * from {$this->_tUser} where id='{$id}'";
        $result = $this->dbDsp->getone($sql);
        return $result;
    }

    public function updateLastLoginTime($id) {
        $array = array('lastLoginTime' => date("Y-m-d H:i:s", time()));
        $result = $this->dbDsp->updateTable($this->_tUser, $array, "where id='{$id}'");
        return $result;
    }

    public function updateUserInfo($array, $id) {
        $result = $this->dbDsp->updateTable($this->_tUser, $array, "where id='{$id}'");
        return $result;
    }

    public function updateCompanyInfo($array, $id) {
        $result = $this->dbDsp->updateTable($this->_tCompany, $array, "where id='{$id}'");
        return $result;
    }

    public function getCompanyInfo($id) {
        $sql = "select * from {$this->_tCompany} where id='{$id}'";
        $result = $this->dbDsp->getOne($sql);
        return $result ? $result : '';
    }

    public function getUserCount($where) {
        $sql = "select count(*) as cnt from {$this->_tUser} {$where}";
        $return = $this->dbDsp->getOne($sql);
        return $return['cnt'] ? $return['cnt'] : 0;
    }

    public function getUserList($limit, $offset, $where) {
        $sql = "select * from {$this->_tUser} {$where} limit {$limit} offset {$offset}";
        $result = $this->dbDsp->getAll($sql);
        return !empty($result) ? $result : array();
    }

}
