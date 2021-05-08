<?php

$_0x41cd = include('conf.php');





$newdata = array();
foreach($_0x41cd as $key => $value )
{
	$newdata['_0x38df("0x'.dechex($key).'")'] = $value;
}

$javascript = file_get_contents('adviad-player.js');
$javascript = str_replace(array_keys($newdata), array_values($newdata), $javascript);
$dd = file_put_contents('/home/adset/public_html/file/cache/adviad.js', $javascript);







$_0x41b3 = include('conf.logger.php');
$newdata = array();
foreach($_0x41cd as $key => $value )
{
	$newdata['_0x38df("0x'.dechex($key).'")'] = $value;
}


print_r($dd);

?>