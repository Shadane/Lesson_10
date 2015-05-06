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
         
         $authorName = $author->getSeller_name();
         $authorMail = $author->getEmail();
        /*
         * пробегаем по массиву с авторами(если этот массив не пуст) и проверяем есть ли совпадения,
         * если есть, то записываем айди.
         */ 
         $response['id']=NULL;
         
         if ($this->store)
         {
            foreach ($this->store as $key=>$au)
             
           { 
                 if ($authorMail == $au->getEmail())
                {
                    $response['id'] = $key; 
                    break;
                }
           }
         } 
           /*
            * если айди записался, то значит такой автор уже существует, и мы отправляем свежеиспеченого 
            * автора на UPDATE, если айди нет, то вставляем в базу новое объявление
            */
            if ($response['id'])
           {
                $response['status'] = static::update($authorName,$authorMail);
           }
            else
           {
                $response = static::insert($authorName,$authorMail);
           }
        
        $this->store[$response['id']] = $author;
        $response['name'] = $authorName;
        $response['email'] = $authorMail;
        return $response;
    }
    
     private function update($authorName,$authorMail) 
    {   
            
        
            if($this->ads_db->query('UPDATE `ads_authors` SET `seller_name`=? WHERE `email`=?' 
                                             ,$authorName,$authorMail))
            {
                $response = 'edit';
            }
            else
            {
                $response = 'not edited';
            }
                
                                    
            
            return $response;
    }
    
     private function insert($authorName, $authorMail)
    {
          if($response['id'] = $this->ads_db->query('INSERT '
                                              .'INTO `ads_authors` (`seller_name`, `email`) '
                                              .'VALUES (?,?) '
                                              ,$authorName,$authorMail))
         {
              $response['status'] = 'new';
         }
          else
         {
              $response['status'] = 'error';
         }
         return $response;
         
    }
    
     public function returnOne($id)
    {
        return $this->store[$id];
    }
    
}
