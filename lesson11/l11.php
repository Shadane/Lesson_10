<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf-8');

// Подключаем библиотеки.
$project_root=  dirname(__FILE__);


require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";

require_once $project_root.'/FirePHPCore/FirePHP.class.php';

require_once $project_root.'/dbsimple+firephp.inc.php';

require_once $project_root.'/db.singleton.class.php';
require_once $project_root.'/l11.ad.class.php';


require($project_root.'/smarty/libs/Smarty.class.php');

$firephp=firephp::getInstance(true);
$firephp->setEnabled(true);
/* Соединение устанавливается через класс-одиночку db_container 
 * и передается ссылкой объектам при их создании.
 */
$adsContainer =new adsContainer;
$firephp->group('adscontainerobj');
$firephp->log($adsContainer);
$firephp->groupEnd();


$citiesContainer = new citiesContainer;
$firephp->group('citiesContainer');
$firephp->log($citiesContainer);
$firephp->groupEnd();


$ctgsContainer = new ctgsContainer;



$authorsContainer= new authorsContainer;
$firephp->group('authorscontainerobj');
$firephp->log($authorsContainer);
$firephp->groupEnd();


//button controller
   if ( isset( $_POST['main_form_submit'] ) ) {    //send button
       
          if ( $_POST['title']&&(($_POST['seller_name']&&$_POST['email'])||($_POST['saved_email'])) ){//если есть (название и (имя+мыло или указано сохраненное)
              $authorsContainer->getAuthorId($_POST);
              $sent_entry = new ad($_POST, $authorsContainer->author_id);

              $return_id = (isset($_POST['return_id'])&& is_numeric($_POST['return_id']))? (int)$_POST['return_id'] : NULL;
              if (!$return_id){
                  $adsContainer->adAdd( $sent_entry );
              }
              else {
                  $adsContainer->adUpdate($sent_entry, $return_id);
              }
          }else{
                $adsContainer->showform['notice_field'] = 'Введите обязательные поля (помечены звездочкой)';
          }
   }elseif ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) {           //delete button
             $adsContainer->adDelete( (int)$_GET['delentry'] );
   }elseif ( isset($_GET['formreturn'] ) && is_numeric($_GET['formreturn'] )) {   //достаточно ли is_numeric для предотвращения инъекций? или нужно прогнать еще через intval? Или лучше привести тип к int?
            $adsContainer->adReturn( (int)$_GET['formreturn'] );

  
   }



$adsContainer->adsLoad();
$authorsContainer->authorsLoad();//не забыть изменить, грузит второй раз.

$adsObjContainer = new adsObjContainer($adsContainer,$authorsContainer); 
$firephp->group('OBJECTS ADS');
$firephp->log($adsObjContainer);
$firephp->groupEnd();





$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $project_root.'/smarty/templates';
$smarty->compile_dir = $project_root.'/smarty/templates_c';
$smarty->cache_dir = $project_root.'/smarty/cache';
$smarty->config_dir = $project_root.'/smarty/configs';

$smarty->assign('radios',array('Частное лицо','Компания'));
$smarty->assign('ads',$adsContainer);
$smarty->assign('adstable',$adsObjContainer);
$smarty->assign('cities',  $citiesContainer);
$smarty->assign('authors',  $authorsContainer);
$smarty->assign('categories',  $ctgsContainer);


$smarty->display('L11.tpl');