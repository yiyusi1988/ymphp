<?php

Core_Init::loadFile('Smarty/Smarty.class.php');

class Core_Smarty {

    public static function getSmarty($params) {
        $smarty = new Smarty();
        $smarty->debugging = $params['debugging'];
        $smarty->caching = $params['caching'];
        $smarty->cache_lifetime = $params['cache_lifetime'];
        $smarty->cache_dir = $params['cache'];
        $smarty->template_dir = $params['templates'];
        $smarty->compile_dir = $params['compile'];
        $smarty->left_delimiter = $params['leftDelimiter'];
        $smarty->right_delimiter = $params['rightDelimiter'];
        return $smarty;
    }

}
