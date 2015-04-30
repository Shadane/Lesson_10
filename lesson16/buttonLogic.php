<?php

require_once 'init.php';
require($project_root.'/smarty/libs/Smarty.class.php');

$storeCarrier = new StoreCarrier(new Adstore, new AuStore, NULL, NULL);

if ( isset( $_POST['private'] ) ) 
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
              $response['submit'] = $storeCarrier->getAdStore()->newSaveRequest($newAd );

          }
           else
          {
              $storeCarrier->setNotice(AdAuthorFactory::buildOne('notice', array('notice_field' => 'Введите обязательные поля (помечены звездочкой)')));
              $response['notice'] = $storeCarrier->getNotice()->getNotice();
          }
   }
    elseif ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) 
   {           //delete button
             $response['delete'] = $storeCarrier->getAdStore()->delete($_GET['delentry']);
   }
   
    elseif ( isset($_GET['formreturn'] ) && is_numeric($_GET['formreturn'] )) 
   {  
             $fieldsForAd = $storeCarrier->getAdStore()->returnOne((int)$_GET['formreturn']);
             if ($fieldsForAd)
            {
                 $fieldsForAd['seller_name']= $storeCarrier->getAuStore()->returnOne($fieldsForAd['author_id'])->getSeller_name();
                 $fieldsForAd['email']= $storeCarrier->getAuStore()->returnOne($fieldsForAd['author_id'])->getEmail();

                 $response['edit'] = $fieldsForAd;
             
            }
   }

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

 if (!isset($_POST['delentry'])&&!isset($_GET['formreturn']))
{
    $response['smarty'] = $smarty->fetch('L16.table.tpl');
}

echo json_encode($response);

