<?php
class citiesContainer {

    private $ads_db;
    public $cities;

    function __construct() {
        $this->ads_db = db_container::getInstance();
        self::citiesLoad();
    }

    private function citiesLoad() {
        $this->cities = $this->ads_db->selectcol('SELECT city_id as ARRAY_KEY, city_name FROM `cities`');
    }

}

class ctgsContainer {

    private $ads_db;
    public $categories;

    function __construct() {
        $this->ads_db = db_container::getInstance();
        self::ctgsLoad();
    }

    private function ctgsLoad() {
        $result = $this->ads_db->select('SELECT cat_id as ARRAY_KEY, category, parent_id as PARENT_KEY  FROM `categories`');
        //преобразуем полученный массив в тот вид, который будет использоваться  в smarty options
        foreach ($result as $val) {
            foreach ($val['childNodes'] as $chkey => $chval) {
                $categories[$val['category']][$chkey] = $chval['category'];
            }
        }
        $this->categories = $categories;
    }

}

class authorsContainer {

    private $ads_db;
    public $authors;
    public $authorsToShow;
    public $author_id;

    function __construct() {
        $this->ads_db = db_container::getInstance();
        self::authorsLoad();
    }

    function authorsLoad() {
        $authors = $this->ads_db->select('SELECT id as ARRAY_KEY, seller_name, email FROM `ads_authors`');
        $this->authors = $authors;
        foreach ($authors as $key => $value) {
            $authors[$key] = 'Имя:&nbsp; ' . $value['seller_name'] . '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Почта:&nbsp;  ' . $value['email'];
        }
        $this->authorsToShow = $authors;
    }
    
    
    
    function getAuthorId(array $sent_entry){
     if ( $sent_entry['email'] && $sent_entry['seller_name']){ //если заполнены поля мыло и имя
                     $result=$this->ads_db->selectcell('SELECT `id` from `ads_authors` WHERE `email`= ?',$sent_entry['email']); //то делаем выборку по мылу
                     if ($result){ //если такое мыло уже есть,
                         $this->ads_db->query('UPDATE `ads_authors` SET `seller_name`=? WHERE `email`= ?',$sent_entry['seller_name'],$sent_entry['email'] );  //прописываем новое имя владельцу мыла.
                         $author_id = $result; // выгружаем из него id автора, которое понадобится для добавления или редактирования объявления
                                
                     }else{         //если же такого мыла нет, то создаем новую запись в базе данных и выгружаем id добавленного автора
                         $author_id=$this->ads_db->query('INSERT INTO `ads_authors` (`seller_name`, `email`) VALUES (?,?)',$sent_entry['seller_name'],$sent_entry['email']);
                                
                     }
     }else { //если же мыло и имя не заполнены в форме
                     $author_id = $_POST['saved_email']; //то возвращаем значение сохраненных записей мыло\имя
     }
       $this->author_id = $author_id;
     }   

}

class ad{
    public $entry;
    
    function __construct(array $entry, $id) {
        $this->entry['private']     =   $entry['private'];
        $this->entry['allow_mails'] =   isset($entry['allow_mails']);
        $this->entry['phone']       =   $entry['phone'];
        $this->entry['location_id'] =   $entry['location_id'];
        $this->entry['category_id'] =   $entry['category_id'];
        $this->entry['title']       =   $entry['title'];
        $this->entry['description'] =   $entry['description'];
        $this->entry['price']       =   $entry['price'];
        $this->entry['author_id']   =   $id;
    }
}
class adShort {
    public $price;
    public $title;
    public $seller_name;
    function __construct(array $ad, $sellername){
               $this->price       =   $ad['price'];
               $this->title       =   $ad['title'];
               $this->seller_name =   $sellername;
               
    }
}

//class author {
//
//    public $entry;
//
//    function __construct(array $author) {
//        $this->entry['seller_name'] = $author['seller_name'];
//        $this->entry['email'] = $author['email'];
//    }
//
//}

class adsContainer {
    private $ads_db;
    public  $adsContainer=array();
    public  $showform;
        function __construct(){
    $this->ads_db = db_container::getInstance();  
    $this->showform['private'] = 0;
    $this->showform['price'] = 0;
    }
 
    
    function adReturn($return_id){
    $this->showform = $this->ads_db->selectrow('SELECT '
                                    . 'ad.id as return_id,ad.author_id as author_id, ad.private, ad.allow_mails, ad.phone, ad.location_id, ad.category_id, ad.title, ad.description, ad.price, au.seller_name, au.email '
                                    . 'FROM `ads_authors` as `au` '
                                    . 'INNER JOIN `ads_container` as `ad` '
                                    . 'ON ad.author_id=au.id '
                                    . 'WHERE ad.id = ?d',$return_id);
    }
    
    

        
    

   function adsLoad() {
       $this->adsContainer = $this->ads_db->select('SELECT '
                                    . 'ad.id as ARRAY_KEY, ad.title as title, ad.price as price, au.seller_name as seller_name, ad.author_id as author_id '
                                    . 'FROM `ads_authors` as `au` '
                                    . 'INNER JOIN `ads_container` as `ad` '
                                    . 'ON ad.author_id=au.id ');
    }
    
    function adUpdate($sent_entry,$return_id){
        $this->ads_db->query('UPDATE `ads_container` SET ?a WHERE id=?d',$sent_entry->entry,$return_id);
    }
    function adAdd($sent_entry){
         $this->ads_db->query('INSERT INTO `ads_container`(?#) VALUES(?a)',  array_keys($sent_entry->entry),array_values($sent_entry->entry));
    }

    function adDelete( $delete_id ){
             $this->ads_db->query('DELETE FROM `ads_container` WHERE `id` = ?d', $delete_id);
}



  
}




class adsObjContainer{
    public $ads=array();

    function __construct(adsContainer $adsContainer,authorsContainer $authorsContainer) {
        self::adsBuilder($adsContainer, $authorsContainer);      
    }
    private function adsBuilder($adsContainer,$authorsContainer ){
        foreach ($adsContainer->adsContainer as $id=>$entry){
            $sellername = $authorsContainer->authors[$entry['author_id']]['seller_name'];
            $this->ads[$id] = new adShort($entry, $sellername);
        }
    }
}


