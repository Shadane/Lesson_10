<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf-8');

// Подключаем библиотеки.
$project_root=  dirname(__FILE__);
require_once $project_root.'/adsfuncs.inc.php';

require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";

require_once $project_root.'/FirePHPCore/FirePHP.class.php';

require_once $project_root.'/dbsimple+firephp.inc.php';

require($project_root.'/smarty/libs/Smarty.class.php');

$firephp=firephp::getInstance(true);
$firephp->setEnabled(true);
// Устанавливаем соединение.
$config_arr = config();
$ads_db = dbconnect($config_arr);

//button controller
   if ( isset( $_POST['main_form_submit'] ) ) {    //send button
          if ( $_POST['title']&&(($_POST['seller_name']&&$_POST['email'])||($_POST['saved_email'])) ){//если есть (название и (имя+мыло или указано сохраненное)
              $_POST['author_id'] = author_controller($ads_db,$_POST);
              $sent_entry = compose_entry($_POST);
              $return_id = (isset($_POST['return_id']))? $_POST['return_id'] : NULL;
              adsSQLSave( $sent_entry, $return_id, $ads_db );
          }else{
                $showform_params['notice_title_is_empty'] = 'Введите обязательные поля (помечены звездочкой)';
          }
   }elseif ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) {           //delete button
             adsSQLDelete( $_GET['delentry'] ,$ads_db);
   }elseif ( isset($_GET['formreturn'] ) && is_numeric($_GET['formreturn'] )) {   //достаточно ли is_numeric для предотвращения инъекций? или нужно прогнать еще через intval? Или лучше привести тип к int?
            $showform_params = adReturn( $ads_db, $_GET['formreturn'] );
   }


$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $project_root.'/smarty/templates';
$smarty->compile_dir = $project_root.'/smarty/templates_c';
$smarty->cache_dir = $project_root.'/smarty/cache';
$smarty->config_dir = $project_root.'/smarty/configs';

$smarty->assign('radios',array('Частное лицо','Компания'));

$smarty->assign('ads_container',adsLoad( $ads_db ));
$smarty->assign('cities',cities_load($ads_db));
$smarty->assign('emails',emails_load($ads_db));
$smarty->assign('categories',categories_load($ads_db));

$showform_params['private']=(isset($showform_params['private']))? $showform_params['private'] : "0"; //не нашел лучшего способа выбрать первый radio по дефолту)
$smarty->assign('showform_params', $showform_params);
$smarty->display('L10.tpl');
