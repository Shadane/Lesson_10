<?php
require_once 'init.php';
require($project_root.'/smarty/libs/Smarty.class.php');

/* Соединение устанавливается через класс-одиночку db_container 
 * и передается ссылкой объектам типа Store при их создании.
 */

$storeCarrier = new StoreCarrier(new Adstore, new AuStore, new CityStore, new CtgsStore);


$firephp->info($storeCarrier);





$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $project_root.'/smarty/templates';
$smarty->compile_dir = $project_root.'/smarty/templates_c';
$smarty->cache_dir = $project_root.'/smarty/cache';
$smarty->config_dir = $project_root.'/smarty/configs';

$smarty->assign('radios',array('Частное лицо','Компания'));
$smarty->assign('cities',$storeCarrier->getCityStore()->getStore());
$smarty->assign('categories',$storeCarrier->getCtgsStore()->getStore() );

$smarty->assign('checkboxAuthors',$storeCarrier->getAuthorsAsCheckbox() );


$smarty->display('L16.tpl');