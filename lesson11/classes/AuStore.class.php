<?php
/*
 * класс для работы с авторами
 */
 class AuStore extends Store
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
                                    
             if ( $author_id == 0)
            {
                $author_id = $this->ads_db->selectcell('SELECT id '
                                                   . 'from `ads_authors` '
                                                   . 'WHERE `email`=?',
                                                     $authorMail);
            }
            return $author_id;
    }
    
}
