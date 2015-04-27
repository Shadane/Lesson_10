<?php
require_once 'init.php';
require($project_root.'/smarty/libs/Smarty.class.php');

/* Соединение устанавливается через класс-одиночку db_container 
 * и передается ссылкой объектам типа Store при их создании.
 */

$storeCarrier = new StoreCarrier(new Adstore, new AuStore, new CityStore, new CtgsStore);

   //button controolller 2
     if ( isset( $_POST['main_form_submit'] ) ) 
    {    //send button
       
           if ( $_POST['title'] &&(( $_POST['email'] && $_POST['seller_name'])||($_POST['saved_email'])) )//если есть (название и (имя+мыло или указано сохраненное)
          {
              /*
               * если указано мыло и имя в полях ввода, то 
               * добавляем нового автора\обновляем 
               * существующего
               */
               if ( $_POST['email'] && $_POST['seller_name'])
              {
                $newAuthor = AdAuthorFactory::buildOne('authors', $_POST);
                $author_id = $storeCarrier->getAuStore()->newSaveRequest($newAuthor);
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
              $newAd = AdAuthorFactory::buildOne('ad', $_POST);
              $storeCarrier->getAdStore()->newSaveRequest($newAd );
          }
           else
          {
              $storeCarrier->setNotice(AdAuthorFactory::buildOne('notice', array('notice_field' => 'Введите обязательные поля (помечены звездочкой)')));
          }
   }
   /*
    * следующий блок переделан с помощью jQuery, поэтому закомментировал
    */
//    elseif ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) 
//   {           //delete button
//             $storeCarrier->getAdStore()->delete($_GET['delentry']);
//   }
    elseif ( isset($_GET['formreturn'] ) && is_numeric($_GET['formreturn'] )) 
   {  
             $fieldsForAd = $storeCarrier->getAdStore()->returnOne((int)$_GET['formreturn']);
             if ($fieldsForAd)
            {
             $storeCarrier->setAuToReturn($storeCarrier->getAuStore()->returnOne($fieldsForAd['author_id']));            
             $storeCarrier->setAdToReturn(adAuthorFactory::buildOne('ad', $fieldsForAd));
             
            }
   }
   


$firephp->info($storeCarrier);





$smarty = new Smarty();

$smarty->compile_check = true;
$smarty->debugging = false;

$smarty->template_dir = $project_root.'/smarty/templates';
$smarty->compile_dir = $project_root.'/smarty/templates_c';
$smarty->cache_dir = $project_root.'/smarty/cache';
$smarty->config_dir = $project_root.'/smarty/configs';

$smarty->assign('radios',array('Частное лицо','Компания'));
$smarty->assign('adToReturn', $storeCarrier->getAdToReturn());
$smarty->assign('auToReturn', $storeCarrier->getAuToReturn());
$smarty->assign('cities',$storeCarrier->getCityStore()->getStore());
$smarty->assign('categories',$storeCarrier->getCtgsStore()->getStore() );
$smarty->assign('ads',$storeCarrier->getAdStore()->getStore() );
$smarty->assign('authors',$storeCarrier->getAuStore()->getStore() );
$smarty->assign('checkboxAuthors',$storeCarrier->getAuthorsAsCheckbox() );
$smarty->assign('notice',$storeCarrier->getNotice() );


$smarty->display('L15.tpl');