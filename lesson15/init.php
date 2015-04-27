<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf-8');
$project_root=  dirname(__FILE__);
require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";
require_once $project_root.'/includes/dbsimple+firephp.inc.php';
require_once $project_root.'/FirePHPCore/FirePHP.class.php';
require $project_root.'/includes/Autoload.inc.php';
$firephp=firephp::getInstance(true);
$firephp->setEnabled(true);
