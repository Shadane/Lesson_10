<?php
/* 
 * этот класс только описывает дочерние.
 */
abstract class store
{
    protected $ads_db;
    protected $store;
    function __construct()
    {
        $this->ads_db = db_container::getInstance();  
    }
    public function loadAll($class, $fields)
    {
        if ($fields) {$this->store = adAuthorFactory::buildmany($class, $fields);}
    }
    
    public function getStore()
    {
         return $this->store;
         
    }
    
    public function newSaveRequest()
    {
        //для городов и категорий пока не делал.
    }
    
}

/*
 * этот класс загружает поля объявлений из базы данных,
 * складирует объекты, полученные из этих полей, сохраняет\обновляет\удаляет объекты.
 * 
 */
class adStore extends store
{    
    /*
     * функция загрузки полей, 
     * parent::LoadALL запускает фабрику, 
     * создающую объекты из этих полей
     */
    public function loadAll($class)
    {
        $fields=$this->ads_db->select('SELECT '
                                    . '`id` as ARRAY_KEY, `title`, `price`, `author_id` '
                                    . 'FROM `ads_container`');
        parent::loadAll($class, $fields);
    }
    /*
     * функция сохранения входящего объекта.
     * сначала из объекта достаются данные - 
     * новый ли он, или возвращенный из формы на сохранение?
     * 
     * затем этот объект получается как массив(исключительно
     * для короткой записи запроса к бд).
     * 
     * если поле - возвращенный из формы - числовое, то
     * делаем update объявления и кладем этот объект на место
     * того что был до него в этой ячейке.
     * 
     * если поле не числовое, то сохраняем объявление как новое
     * и по сохраненному ID добавляем объект на склад объявлений.
     * 
     */
    public function newSaveRequest( ad $newAd) 
    {
        $return_id = $newAd->getReturn_id();
        $adAsArray = $newAd->getAsArray();
        
        if (is_numeric($return_id)) 
        {
            static::update($adAsArray, $return_id);
            $this->store[$return_id] = $newAd;
        } 
        else 
        {
            $id = static::save($adAsArray);
            $this->store[$id] = $newAd;
        }
    }
    
    
    
    private function update($adAsArray, $return_id)
    {
        $this->ads_db->query('UPDATE `ads_container` '
                            .'SET ?a '
                            .'WHERE id=?d',
                             $adAsArray,$return_id);
    }
    
    private function save($adAsArray)
    {

        $id = $this->ads_db->query('INSERT INTO '
                                 . '`ads_container`'
                                 . '(?#) '
                                 . 'VALUES'
                                 . '(?a)',  
                                   array_keys($adAsArray),array_values($adAsArray));
        return $id;
    }
    /*
     * по id удаляем из базы объявление, делаем unset объекта с таким значением id
     */
    public function delete($id)
    {
        $del = $this->ads_db->query('DELETE FROM `ads_container` WHERE `id` = ?d', $id);
        
        if ($del == 1)
        {
            unset($this->store[$id]);
        }
    }
    /*
     * эта функция срабатывает при нажатии на название объявления.
     * Несмотря на то, что у склада идет работа только с таблицой ads_container
     * я не нашел другого нормального способа соединить две сущности.
     * 
     * если такого объявления, которое мы возвращаем - не существует,
     * то ничего не возвращаем.
     * 
     * если существует, то с помощью фабрики создаем новое объявление, которое
     * содержит обе сущности.
     */
    public function returnAd($id)
    {
        $fields = $this->ads_db->selectrow('SELECT '
                                    . 'ad.id as return_id,ad.author_id as author_id, ad.private, ad.allow_mails, ad.phone, ad.location_id, ad.category_id, ad.title, ad.description, ad.price, au.seller_name, au.email '
                                    . 'FROM `ads_authors` as `au` '
                                    . 'INNER JOIN `ads_container` as `ad` '
                                    . 'ON ad.author_id=au.id '
                                    . 'WHERE ad.id = ?d',
                                           $id);
        if (!$fields) return;
        $adToReturn = adAuthorFactory::buildOne('adAuthorMix', $fields);
        return $adToReturn;
    }

}
/*
 * класс для работы с авторами
 */
class auStore extends store
{
    /*
     * загружает поля с объявлеиями из базы и отдает их
     * parent:loadAll на фабрику создания авторов, затем кладет 
     * созданные объекты-авторы себе на склад.
     */
    public function loadAll($class) 
    {
        $fields = $this->ads_db->select('SELECT '
                                       .'id as ARRAY_KEY, seller_name, email '
                                       .'FROM `ads_authors`');
        parent::loadAll($class, $fields);
        
    }
    
    public function newSaveRequest(authors $author)
    {
        /*
         * сюда у нас поступает свежеиспеченный автор
         * и отправляется на сохранение(см ниже),
         * затем кладется на склад.
         */
        $author_id = static::save($author);
        $this->store[$author_id] = $author;
        return $author_id;
    }
    /*
     * вместо написания кучи условий и ветвлений с save и update
     * я сделал ON DUPLICATE KEY UPDATE, который решает это сам.
     * 
     * Поле email в базе данных - уникальный ключ, по нему и смотрится
     * апдейт это или сейв.
     * 
     * Если у нас происходит UPDATE on duplicate, то в переменную author_id 
     * у нас возвращается ноль, поэтому далее стоит условие: если author_id ==0,
     * то мы загружаем ID из обновленного автора.
     */
    private function save(authors $author) 
    {   
            $authorName = $author->getName();
            $authorMail = $author->getMail();
        
            $author_id = $this->ads_db->query('INSERT '
                                             .'INTO `ads_authors` (`seller_name`, `email`) '
                                             .'VALUES (?,?) '
                                             .'ON DUPLICATE KEY UPDATE '
                                             .'`seller_name`=?' 
                                             ,$authorName,$authorMail,$authorName);
                                    
            if ( $author_id == 0) $author_id = $this->ads_db->selectcell('SELECT id '
                                                   . 'from `ads_authors` '
                                                   . 'WHERE `email`=?',
                                                     $authorMail);
            return $author_id;
    }
    
}
/*
 * класс для загрузки списка городов
 */
class cityStore extends store
{
    public function loadAll()
    {
        $this->store = $this->ads_db->selectcol('SELECT '
                                               .'city_id as ARRAY_KEY, city_name '
                                               .'FROM `cities`');
    }
}
/*
 * класс для загрузки списка категорий
 */
class ctgsStore extends store
{
    public function loadAll()
    {
        $result = $this->ads_db->select('SELECT '
                                       .'cat_id as ARRAY_KEY, category, parent_id as PARENT_KEY  '
                                       .'FROM `categories`');
        foreach ($result as $val) {
            foreach ($val['childNodes'] as $chkey => $chval) {
                $categories[$val['category']][$chkey] = $chval['category'];
            }
        }
        $this->store = $categories;
    }
}

    

class adAuthorFactory
{
    public static function buildmany($class, array $fields)
    {
         
        require_once $class.'.class.php';
        if (!class_exists($class)) {die ('Invalid class given to build an object'); }
        
        foreach ($fields as $id=>$data)
        {
            $objects[$id] = new $class($data);
        }
        return $objects;
    }
    
    public static function buildOne($class ,array $fields)
    {
        require_once $class.'.class.php';
        if (!class_exists($class)) {die ('Invalid class given to build an object'); }
        
        $object = new $class($fields);
        return $object;
    }
}
