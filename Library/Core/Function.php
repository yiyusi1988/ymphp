<?php

/**
 * 全局公共方法,允许任何时候、任何地方调用，但不建议什么乱七八糟的东西都往这里面仍
 * Yimiao
 * 2013-12-20
 */

/**
 * 
 * @return type
 * 公共方法里面使用db、mem范例 均是new ComModel 这个基础类 但不建议在公共方法里使用db和mem
 * 
 */
function testfunctiondb() {
    $model = new ComModel();
    $sql = "select * from umy4399.umy_ads limit 1";
    $return = $model->dbUnion->getAll($sql);
    return $return;
}

/**
 * 
 * @param type $file
 * @param type $content
 * @param type $model
 * @return boolean
 * 简单写入文件操作
 */
function writefile($file, $content, $model = 'a+') {
    $fp = fopen($file, $model);
    if (!$fp) {
        return false;
    }
    fwrite($fp, $content);
    fclose($fp);
    return true;
}

/**
 * 
 * @param type $folder
 * @return boolean
 * 检查创建文件夹
 */
function mkdirFolder($folder) {
    if (!file_exists($folder)) {
        if (!mkdir($folder, 0777)) {
            return false;
        }
    }
    return true;
}

/**
 * 
 * @return type
 * 获取底层ip
 */
function getIp() {
    return $_SERVER['REMOTE_ADDR'];
}

/**
 * 
 * @param type $message
 * 记录错误记录
 */
function errorLog($message) {
    $ip = getIp();
    $nowtime = date("Y-m-d H:i:s");
    $message.="\r\n客户IP:{$ip}";
    $message.="\r\n时间:{$nowtime}\r\n";
    $folder = '../log/';
    mkdirFolder($folder);
    $errorFile = $folder . date("Y-m-d") . '.txt';
    writefile($errorFile, $message, 'a+');
}

/**
 * 
 * @param type $array
 * @param type $level
 * @return type
 * 数组字符串化
 */
function arrayEval($array, $level = 0) {
    if (!is_array($array)) {
        return $array;
    }
    $space = '';
    for ($i = 0; $i <= $level; $i++) {
        $space .= "\t";
    }
    $evaluate = "Array\n$space(\n";
    $comma = $space;
    foreach ($array as $key => $val) {
        $key = is_string($key) ? '\'' . addcslashes($key, '\'\\') . '\'' : $key;
        $val = !is_array($val) && (!preg_match("/^\-?\d+$/", $val) || strlen($val) > 12) ? '\'' . addcslashes($val, '\'\\') . '\'' : $val;
        if (is_array($val)) {
            $evaluate .= "$comma$key => " . arrayEval($val, $level + 1);
        } else {
            $evaluate .= "$comma$key => $val";
        }
        $comma = ",\n$space";
    }
    $evaluate .= "\n$space)";
    return $evaluate;
}

function saveFile($path, $content) {
    if (@$fp = fopen($path, 'w')) {
        flock($fp, 2);
        fwrite($fp, $content);
        fclose($fp);
        chown($path, 'www');
        chgrp($path, 'www');
        return true;
    } else {
        return true;
    }
}

function getQueryString() {
    $siteConf = Core_Init::getConf('Conf_Site');
    if ($siteConf['isHtml'] == 1) {
        $ym_server = str_replace('.' . $siteConf['suffix'], "", $_SERVER['REQUEST_URI']);
        $_SGETS = explode("/", substr($ym_server, 1));
        $_SLEN = count($_SGETS);
        $_SGET = $_GET;
        for ($i = 3; $i < $_SLEN; $i+=2) {
            if (!empty($_SGETS[$i]) && !empty($_SGETS[$i + 1])) {
                $_SGET[$_SGETS[$i]] = $_SGETS[$i + 1];
            }
        }
        return $_SGET;
    } else {
        return $_GET;
    }
}

/**
 * 截取汉字字符串 
 */
function cut_str($string, $sublen, $start = 0, $code = 'utf-8') {
    if ($code == 'utf-8') {
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/";
        preg_match_all($pa, $string, $t_string);
        if (count($t_string[0]) - $start > $sublen)
            return join('', array_slice($t_string[0], $start, $sublen)) . "...";
        return join('', array_slice($t_string[0], $start, $sublen));
    }
    else {
        $start = $start * 2;
        $sublen = $sublen * 2;
        $strlen = strlen($string);
        $tmpstr = '';

        for ($i = 0; $i < $strlen; $i++) {
            if ($i >= $start && $i < ($start + $sublen)) {
                if (ord(substr($string, $i, 1)) > 129) {
                    $tmpstr.= substr($string, $i, 2);
                } else {
                    $tmpstr.= substr($string, $i, 1);
                }
            }
            if (ord(substr($string, $i, 1)) > 129)
                $i++;
        }
        if (strlen($tmpstr) < $strlen)
            $tmpstr.= "...";
        return $tmpstr;
    }
}

/*
 * 分类管理获取父级分类名
 */

function getFidName($id) {
    $classifyList = Core_Init::getConf('Conf_Classify');
    return $classifyList[$id];
}

/**
 * 获取该分类的list
 */
function getClassifyList($fid) {
    $sql = "select * from dspadmin.classify where fid='{$fid}' and status=1 order by sort desc";
    $mode = new Core_Model();
    $result = $mode->dbDsp->getAll($sql);
    return $result;
}

/**
 * 
 * @param type $id
 * @return type获取分类名
 */
function getClassifyNameById($id) {
    $sql = "select name from dspadmin.classify where id='{$id}' and status=1";
    $mode = new Core_Model();
    $result = $mode->dbDsp->getOne($sql);
    return $result['name'];
}

function beginTrans() {
    $model = new Core_Model();
    $model->dbDsp->query("START TRANSACTION");
}

function commit() {
    $model = new Core_Model();
    $model->dbDsp->query("COMMIT");
}

function rollback() {
    $model = new Core_Model();
    $model->dbDsp->query("ROLLBACK");
}
