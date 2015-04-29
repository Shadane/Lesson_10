<?php

require_once 'init.php';
require($project_root.'/smarty/libs/Smarty.class.php');

$storeCarrier = new StoreCarrier(new Adstore, new AuStore, new CityStore, new CtgsStore);


$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $project_root.'/smarty/templates';
$smarty->compile_dir = $project_root.'/smarty/templates_c';
$smarty->cache_dir = $project_root.'/smarty/cache';
$smarty->config_dir = $project_root.'/smarty/configs';

$smarty->assign('checkboxAuthors',$storeCarrier->getAuthorsAsCheckbox() );
$smarty->assign('ads',$storeCarrier->getAdStore()->getStore() );
$smarty->assign('authors',$storeCarrier->getAuStore()->getStore() );

$smarty->display('L16.table.tpl');
