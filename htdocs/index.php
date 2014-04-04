<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

(phpversion() < '5.3.0') ? error_reporting(E_ALL & ~ E_NOTICE) : error_reporting(E_ALL & ~ E_NOTICE & ~ E_DEPRECATED);
date_default_timezone_set('Asia/Shanghai');
set_include_path('.' . PATH_SEPARATOR . '../Library' . PATH_SEPARATOR . '../Application' . PATH_SEPARATOR . get_include_path());
require_once 'Core/Init.php';
//require_once 'Core/Function.php';
Core_Init::loadClass('Core_Registry');
Core_Init::loadFile('Core/Function.php');
Core_Registry::register();
$_GET = getQueryString();
session_start();
$siteConf = Core_Init::getConf('Conf_Site');
define('MAINURL', $siteConf['liveSite']);
define('SITENAME', $siteConf['siteName']);

Core_Init::run();

