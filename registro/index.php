<?php
if ( !isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != 'on' )
{
	$Host = str_replace('www.','',$_SERVER['HTTP_HOST']);
	header("Location: https://".$Host.$_SERVER['REQUEST_URI']);
	exit();
}

if( strstr($_SERVER['HTTP_HOST'],'www.') )
{
	header("Location: https://".substr($_SERVER['HTTP_HOST'],4).$_SERVER['REQUEST_URI']);
	exit();
}

if ( strpos($_SERVER['REQUEST_URI'], 'index') !== false )
{
	header("Location: ./");
	exit();
}

date_default_timezone_set('America/Mexico_City');
session_start();

$Step = isset($_GET['s'])?"{$_GET['s']}.php":"1.php";
include_once($Step);
?>
