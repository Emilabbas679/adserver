<?php
/**
 * Front controller for default Minify implementation.
 *
 * DO NOT EDIT! Configure this utility via config.php and groupsConfig.php
 */
define('MINIFY_MIN_DIR', dirname(__FILE__));

// set config path defaults
$min_configPaths = [
    'base' => MINIFY_MIN_DIR.'/config.php',
    'test' => MINIFY_MIN_DIR.'/config-test.php',
    'groups' => MINIFY_MIN_DIR.'/groupsConfig.php',
];

// check for custom config paths
if (!empty($min_customConfigPaths) && is_array($min_customConfigPaths)) {
    $min_configPaths = array_merge($min_configPaths, $min_customConfigPaths);
}

// load config
require $min_configPaths['base'];

require "$min_libPath/Minify/Loader.php";
Minify_Loader::register();

$min_serveOptions['minifierOptions']['text/css']['symlinks'] = $min_symlinks;

 $groupSources = [
    'js' => [
         $min_documentRoot.'/theme/frontend/oxu/style/default/js/jquery.js',

         $min_documentRoot.'/static/jscript/common.js',
         $min_documentRoot.'/static/jscript/main.js',
         $min_documentRoot.'/static/jscript/ajax.js',

         $min_documentRoot.'/theme/frontend/oxu/style/default/js/xate.js',
    ],
    'css' => [
         $min_documentRoot.'/theme/frontend/oxu/style/default/css/style.css',
    ],
 ];

 $jsBuild = Minify_CSSmin::minify(file_get_contents($min_documentRoot.'/theme/frontend/oxu/style/default/css/style.css'));

echo $jsBuild;
