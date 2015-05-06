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


if ( isset( $_POST['main_form_submit'] ) ) 
    {    //send button

                $author = AdAuthorFactory::buildOne('authors', $_POST);
                
                /*
                 * в нижеидущем респонсе мы получаем:
                 *  $response['author']['name']
                 *  $response['author']['email']
                 *  $response['author']['id']
                 *  $response['author']['status']
                 * 
                 * status может быть 'new', 'edit', 'not edited', 'error'
                 */
                $response['author'] = $storeCarrier->getAuStore()->newSaveRequest($author);
                
                
                
                 $smarty->assign('auName', $response['author']['name']);
                
                
               /*
               * если статус автора НОВЫЙ или ОТРЕДАКТИРОВАННЫЙ, 
               * то заливаем темплейт для append'ивания в нашу форму
               * (в клиентской части соответственно произойдет следующее:
                * status = new - аппендим автора в выпадающий список
                * status = edit - replace'им, т.е заменяем автора в списке, 
                * а также по $response['author']['id'] находим среди
                * объявлений колонку с такими айди <td id="этот самый айди"> и 
                * перезаписываем значение в ней на $response['author']['name'] )
               */
               if ($response['author']['status']=='new' || $response['author']['status']=='edit')
              {
                    $smarty->assign('auEmail', $response['author']['email']);
                    
                    $response['author']['menuItem']=$smarty->fetch('l17.authorMenu.tpl');
              }
              
              
              
              /* 
               * Далее работаем с объявлением.
               * id из вышеидущей части записываем в пост
               * для удобства
               */
              $_POST['author_id'] = $response['author']['id'];
             
              /*
               * создаем новое объявление.
               */
              $newAd = AdAuthorFactory::buildOne('ad', $_POST);
              
              /*
               * и отправляем его на сохранение.
               * возможные респонсы:
               * $response['submit'] = 'new'
               * $response['submit'] = 'edit'
               * $response['submit'] = 'not edited'
               * $response['submit'] = 'error'
               */
              $response['submit'] = $storeCarrier->getAdStore()->newSaveRequest($newAd );
              
              
              $smarty->assign('ad', $newAd);
              /*
               * Следующий authorId вставляется в <td id="{$authorId}"> в темплейте.
               * Это необходимо для того, чтобы в последствии при изменении автора в одном месте 
               * менялся текст с именем автора во всех объявлениях.
               */
              $smarty->assign('authorId', $response['author']['id']);
              $response['smarty'] = $smarty->fetch('l17.table_row.tpl');
              
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
    else
   {


            $smarty->assign('checkboxAuthors',$storeCarrier->getAuthorsAsCheckbox() );
            $smarty->assign('ads',$storeCarrier->getAdStore()->getStore() );
            $smarty->assign('authors',$storeCarrier->getAuStore()->getStore() );

            $smarty->assign('radios',array('Частное лицо','Компания'));
            $smarty->assign('cities',$storeCarrier->getCityStore()->getStore());
            $smarty->assign('categories',$storeCarrier->getCtgsStore()->getStore() );


            $smarty->display('l17.tpl');
    }
if (isset($response)) {echo json_encode($response);}



