<?php
 function cities_load($ads_db){
                $cities = $ads_db->selectcol('SELECT city_id as ARRAY_KEY, city_name FROM `cities`');
                return $cities;

     }   
 function categories_load($ads_db){
                $result = $ads_db->select('SELECT cat_id as ARRAY_KEY, category, parent_id as PARENT_KEY  FROM `categories`');
                //преобразуем полученный массив в тот вид, который будет использоваться  в smarty options
                foreach ($result as $val){
                    foreach ($val['childNodes'] as $chkey=>$chval){
                    $categories[$val['category']][$chkey]=$chval['category'];
                    }
                }
                return $categories;

     }   
 function emails_load($ads_db){
                $emails = $ads_db->select('SELECT id as ARRAY_KEY, seller_name, email FROM `ads_authors`');
                foreach ($emails as $key=>$value){
                    $emails[$key] = 'Имя:&nbsp; '. $value['seller_name'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Почта:&nbsp;  '.$value['email'];
                }
                return $emails;
 }

function author_controller($ads_db, $sent_entry){
     if ( $sent_entry['email'] && $sent_entry['seller_name']){ //если заполнены поля мыло и имя
                     $result=$ads_db->selectcell('SELECT `id` from `ads_authors` WHERE `email`= ?',$sent_entry['email']); //то делаем выборку по мылу
                     if ($result){ //если такое мыло уже есть,
                         $ads_db->query('UPDATE `ads_authors` SET `seller_name`=? WHERE `email`= ?',$sent_entry['seller_name'],$sent_entry['email'] );  //прописываем новое имя владельцу мыла.
                         $author_id = $result; // выгружаем из него id автора, которое понадобится для добавления или редактирования объявления
                                
                     }else{         //если же такого мыла нет, то создаем новую запись в базе данных и выгружаем id добавленного автора
                         $author_id=$ads_db->query('INSERT INTO `ads_authors` (`seller_name`, `email`) VALUES (?,?)',$sent_entry['seller_name'],$sent_entry['email']);
                                
                     }
     }else { //если же мыло и имя не заполнены в форме
                     $author_id = $_POST['saved_email']; //то возвращаем значение сохраненных записей мыло\имя
     }
 return $author_id;
}

function compose_entry($data){
    $entry=array(
        'private'     =>   $data['private'],
        'allow_mails' =>   isset($data['allow_mails']),
        'phone'       =>   $data['phone'],
        'location_id' =>   $data['location_id'],
        'category_id' =>   $data['category_id'],
        'title'       =>   $data['title'],
        'description' =>   $data['description'],
        'price'       =>   $data['price'],
        'author_id'   =>   $data['author_id']
    );
    return $entry;
}

function adsSQLSave( $sent_entry, $return_id, $ads_db){ 

    if ( isset( $return_id )  &&  is_numeric( $return_id ) ){
               $ads_db->query('UPDATE `ads_container` SET ?a WHERE id=?d',$sent_entry,(int)$return_id);
    }else{   
               $ads_db->query('INSERT INTO `ads_container`(?#) VALUES(?a)',  array_keys($sent_entry),array_values($sent_entry));
       

    }
}

function adsSQLDelete( $delete_id, $ads_db){
             $ads_db->query('DELETE FROM `ads_container` WHERE `id` = ?d', (int)$delete_id);
}

function adReturn( $ads_db, $return_id ){
         $result = $ads_db->selectrow('SELECT '
                                    . 'ad.id as return_id, ad.private, ad.allow_mails, ad.phone, ad.location_id, ad.category_id, ad.title, ad.description, ad.price, au.seller_name, au.email '
                                    . 'FROM `ads_authors` as `au` '
                                    . 'INNER JOIN `ads_container` as `ad` '
                                    . 'ON ad.author_id=au.id '
                                    . 'WHERE ad.id = ?d',(int)$return_id);
            return $result;
}

function adsLoad( $ads_db ) { 
        $ads_res = $ads_db->select('SELECT ads.id as ARRAY_KEY, ads.title, ads.price, auth.seller_name FROM `ads_container`as `ads` INNER JOIN `ads_authors` as `auth` on ads.author_id=auth.id ORDER by ads.id');
        return $ads_res;
}

