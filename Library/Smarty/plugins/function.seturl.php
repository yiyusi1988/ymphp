<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function smarty_function_seturl($params, &$smarty) {
    $url = Core_Init::seturl($params);
    return $url;
}
