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
require_once $project_root.'/adrefactored.class.php';
require_once $project_root.'/adOutput.class.php';



require($project_root.'/smarty/libs/Smarty.class.php');

$firephp=firephp::getInstance(true);
$firephp->setEnabled(true);
/* Соединение устанавливается через класс-одиночку db_container 
 * и передается ссылкой объектам при их создании.
 */

$adStore= new adStore;
$adStore->loadAll('ads');

$auStore= new auStore;
$auStore->loadAll('authors');

$cityStore= new cityStore;
$cityStore->loadAll();

$ctgsStore= new ctgsStore;
$ctgsStore->loadAll();


   //button controolller 2
    if ( isset( $_POST['main_form_submit'] ) ) 
    {    //send button
       
          if ( $_POST['title'] &&(( $_POST['email'] && $_POST['seller_name'])||($_POST['saved_email'])) ){//если есть (название и (имя+мыло или указано сохраненное)
          
              /*
               * если указано мыло и имя в полях ввода, то 
               * добавляем нового автора\обновляем 
               * существующего
               */
              if ( $_POST['email'] && $_POST['seller_name'])
              {
                $newAuthor = adAuthorFactory::buildOne('authors', $_POST);
                $author_id = $auStore->newSaveRequest($newAuthor);
              }
              /*
               * В противном случае смотрим указан ли 
               * пользователь из списка
               */
              elseif ($_POST['saved_email'])
              {
                  $author_id = $_POST['saved_email'];
              }
              /* 
               * Далее работаем с объявлением.
               * id из вышеидущей части записываем в пост
               * для удобства
               */
              $_POST['author_id'] = $author_id;
              /*
               * с помощью нашего завода создаем
               * новое объявление
               */
              
              $newAd = adAuthorFactory::buildOne('ad', $_POST);
              $adStore->newSaveRequest($newAd );
          }else{
              $notice = adAuthorFactory::buildOne('notice', array('notice_field' => 'Введите обязательные поля (помечены звездочкой)'));
          }
   }elseif ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) {           //delete button
             $adStore->delete($_GET['delentry']);
   }elseif ( isset($_GET['formreturn'] ) && is_numeric($_GET['formreturn'] )) {   //достаточно ли is_numeric для предотвращения инъекций? или нужно прогнать еще через intval? Или лучше привести тип к int?
             $adToReturn = $adStore->returnAd((int)$_GET['formreturn']);

  
   }
   
   /*
    * если не возвращается никакое объявление, то создаем объект, который покажет пустые поля,
    * 
    */
   
$adToReturn = (isset($adToReturn))? $adToReturn : adAuthorFactory::buildOne('placeholder', array('return_id' => '',
                                                                                                 'author_id' =>  '',
                                                                                                 'private' =>  '0',
                                                                                                 'allow_mails' =>  '0',
                                                                                                 'phone' =>  '' ,
                                                                                                 'location_id' =>  '' ,
                                                                                                 'category_id' =>  '' ,
                                                                                                 'title' =>  '',
                                                                                                 'description' =>  '',
                                                                                                 'price' =>  '0',
                                                                                                 'seller_name' =>  '',
                                                                                                 'email' =>  '')); 
/*
 * не понимаю зачем нужен класс вывода ,
 * но я его сделал
 */

$adOutput = new adOutput($adStore->getStore(), $auStore->getStore(), $adToReturn, $cityStore->getStore(), $ctgsStore->getStore());
$firephp->info($adOutput);

/*
 * если есть notice, то он отобразится у нас в выводе
 */
if (isset($notice))
{
    $adOutput->setNotice ($notice);
}




$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $project_root.'/smarty/templates';
$smarty->compile_dir = $project_root.'/smarty/templates_c';
$smarty->cache_dir = $project_root.'/smarty/cache';
$smarty->config_dir = $project_root.'/smarty/configs';

$smarty->assign('radios',array('Частное лицо','Компания'));
$smarty->assign('adToReturn', $adOutput->getAdToReturn());
$smarty->assign('cities',$adOutput->getCities() );
$smarty->assign('categories',$adOutput->getCategories() );
$smarty->assign('ads',$adOutput->getAds() );
$smarty->assign('authors',$adOutput->getAuthors() );
$smarty->assign('checkboxAuthors',$adOutput->getAsCheckbox() );
$smarty->assign('notice',$adOutput->getNotice() );


$smarty->display('L11.tpl');