<?php

error_reporting(0);
//error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);

date_default_timezone_set('Asia/Baku');

define('AIN_DS', DIRECTORY_SEPARATOR);

define('AIN_DIR', dirname(dirname(__FILE__)));

$size = isset($_GET['size']) ? $_GET['size'] : 'orginal';
$file = isset($_GET['file']) ? $_GET['file'] : '';
$imgDir = AIN_DIR.'/file/articles/'.$file;

if (!is_file($imgDir)) {
    $size = explode('x', $size);

    header('HTTP/1.0 404 Not Found');
    $sText = "( image not found ).\n";

    $nW = $size[0];
    $nH = $size[1];

    $nLeft = 10;
    $nTop = ($nH / 2 - 10);
    $hImg = imagecreate($nW, $nH);
    $nBgColor = imagecolorallocate($hImg, 0, 0, 0);
    $nTxtColor = imagecolorallocate($hImg, 255, 255, 255);
    $aLines = explode("\n", $sText);
    foreach ($aLines as $sLine) {
        imagestring($hImg, 5, $nLeft, $nTop, $sLine, $nTxtColor);
        $nTop += 17;
    }
    ob_clean();
    header('Content-Type: image/jpeg');
    imagejpeg($hImg);
    exit;
}

function cache_file()
{
    // something to (hopefully) uniquely identify the resource
    //$cache_key = md5($_SERVER['QUERY_STRING']);
    $cache_key = md5($_GET['file']).'.jpg';
    $cache_key = str_replace('/', '_', $cache_key);
    $cache_dir = AIN_DIR.'/file/cache/image/';

    if (!is_dir($cache_dir)) {
        mkdir($cache_dir);
        chmod($cache_dir, 0777);
    }

    $date_dir = date('Ym');
    $cache_dir = $cache_dir.'/'.$date_dir;

    if (!is_dir($cache_dir)) {
        mkdir($cache_dir);
        chmod($cache_dir, 0777);
    }

    $date_dir = $_GET['size'];
    $cache_dir = $cache_dir.'/'.$date_dir;

    if (!is_dir($cache_dir)) {
        mkdir($cache_dir);
        chmod($cache_dir, 0777);
    }

    return $cache_dir.'/'.$cache_key;
}

// if we have a cache file, deliver it
if (is_file($cache_file = cache_file())) {
    header('Content-type: image/jpeg');
    readfile($cache_file);
    exit;
}
// cache via output buffering, with callback
ob_start('cache_output');

function cache_output($content)
{
    file_put_contents(cache_file(), $content);

    return $content;
}

require AIN_DIR.'/include/plugin/image/class.upload.php';

$handle = new upload($imgDir);

if ('orginal' == $size) {
} elseif (stripos($size, 'x')) {
    $handle->image_resize = true;
    $size = explode('x', $size);
    $handle->image_x = $size[0];
    $handle->image_y = $size[1];
    $handle->image_ratio_crop = true;
    $handle->image_opacity = 100;
} else {
    $handle->image_resize = true;
    $handle->image_max_width = $size;
    $handle->image_ratio_crop = true;
    $handle->image_opacity = 100;
}
header('Content-type: '.$handle->file_src_mime);
echo $handle->Process();
die();
