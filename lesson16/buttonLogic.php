<?php
require_once 'init.php';

$storeCarrier = new StoreCarrier(new Adstore, new AuStore, new CityStore, new CtgsStore);


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
              $response = $storeCarrier->getAdStore()->newSaveRequest($newAd );
              echo json_encode($response);
          }
           else
          {
              $storeCarrier->setNotice(AdAuthorFactory::buildOne('notice', array('notice_field' => 'Введите обязательные поля (помечены звездочкой)')));
              echo json_encode($storeCarrier->getNotice()->getNotice());
          }
   }
    elseif ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) 
   {           //delete button
             $response = $storeCarrier->getAdStore()->delete($_GET['delentry']);
             echo json_encode($response);
   }
   
    elseif ( isset($_GET['formreturn'] ) && is_numeric($_GET['formreturn'] )) 
   {  
             $fieldsForAd = $storeCarrier->getAdStore()->returnOne((int)$_GET['formreturn']);
             if ($fieldsForAd)
            {
                 $fieldsForAd['seller_name']= $storeCarrier->getAuStore()->returnOne($fieldsForAd['author_id'])->getSeller_name();
                 $fieldsForAd['email']= $storeCarrier->getAuStore()->returnOne($fieldsForAd['author_id'])->getEmail();
//             $storeCarrier->setAuToReturn($storeCarrier->getAuStore()->returnOne($fieldsForAd['author_id']));            
//             $storeCarrier->setAdToReturn(adAuthorFactory::buildOne('ad', $fieldsForAd));
                 echo $me=json_encode($fieldsForAd);
             
            }
   }
   
  
