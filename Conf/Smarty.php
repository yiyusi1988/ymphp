<?php
/**
 * smarty 配置数组
 */

return array(
    'debugging' => false,
    'caching' => false,
    'cache_lifetime' => 120,
    'cache' => '../SmartyTemplates/Cache',
    'templates' => '../SmartyTemplates/Templates',
    'compile' => '../SmartyTemplates/Templates_c',
    'leftDelimiter' => '<*',
    'rightDelimiter' => '*>'
);
