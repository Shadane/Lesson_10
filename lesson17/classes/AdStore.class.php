<?php

/*
 * этот класс загружает поля объявлений из базы данных,
 * складирует объекты, полученные из этих полей, сохраняет\обновляет\удаляет объекты.
 * 
 */
 class AdStore extends Store
{    
    /*
     * функция загрузки полей, 
     * parent::LoadALL запускает фабрику, 
     * создающую объекты из этих полей
     */
     public function loadAll($class)
    {
        $fields=$this->ads_db->select('SELECT '
                                    . '`id` as ARRAY_KEY, `title`, `price`, `author_id`, `private` '
                                    . 'FROM `ads_container`');
        
         if ($fields)
        {
             foreach ($fields as $id=>$data)
            {
                $this->store[$id] = adAuthorFactory::buildOne($class, $data);
            }
        }
        return $this;
//        parent::loadAll($class, $fields);
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
     public function newSaveRequest(Ads $newAd) 
    {
         /*
          * достаем айди из объявления,
          * если оно есть, значит редактируем объявление,
          * если нет - то это новое объявление.
          */
        $return_id = $newAd->getId();
        $adAsArray = $newAd->getAsArray();
        if ($return_id){
            $id = static::update($adAsArray,$return_id);
        }else
        {
            $id = static::insert($adAsArray);
        }
            /*
             * засовываем это объявление в хранилище
             * 
             */
            $newAd->setId(($return_id)? $return_id : $id['id']);
            $this->store[$newAd->getId()] = $newAd;
            return $id['adstatus'];
    }
    
    
    /*
     * я использую Insert INTO а не REPLACE into потому,
     * что replace не возвращает айди.
     */
     private function insert($adAsArray)
    {

       if( $id['id'] = $this->ads_db->query('INSERT INTO '
                                 . '`ads_container` '
                                 . '(?#) '
                                 . 'VALUES '
                                 . '(?a) ',  
                                   array_keys($adAsArray),array_values($adAsArray))
          )
        {       
            $id['adstatus'] = 'new';
        }else{
            $id['adstatus'] = 'error';
        }
        return $id;
    }
    
    
    
    private function update($adAsArray,$return_id)
    {

       if(    $this->ads_db->query('UPDATE '
                                 . '`ads_container` '
                                 . 'SET '
                                 . '?a  '
                                 . 'WHERE id=?d',  
                                   $adAsArray,$return_id)
          )
        {       
            $id['adstatus'] = 'edit';
        }else{
            $id['adstatus'] = 'not edited';
        }
        return $id;
    }
    
    
    
    /*
     * по id удаляем из базы объявление, делаем unset объекта с таким значением id
     */
     public function delete($id)
    {
         if ($del = $this->ads_db->query('DELETE FROM `ads_container` WHERE `id` = ?d', $id))
        {
             $response['status'] = 'success';
             $response['message'] = 'Объявление '.$id.' успешно удалено';
             unset($this->store[$id]);
        }
         else
        {
             $response['status'] = 'error';
             $response['message'] = 'Ошибка при удалении объявления';
        }
        return $response;
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
     * содержит обе сущности. Сделать иначе достаточно проблематично пока классы
     * не знают друг о друге.
     */
     public function returnOne($id)
    {
        $fields = $this->ads_db->selectrow('SELECT '
                                    . 'id, private, allow_mails, phone, location_id, category_id, description '
                                    . 'FROM '
                                    . '`ads_container` '
                                    . 'WHERE id = ?d',
                                           $id);
        if (!$fields) return;
        
        if ($fields['allow_mails']==0) unset ($fields['allow_mails']);
        $fields['author_id'] = $this->store[$id]->getAuthor_id();
        $fields['title'] = $this->store[$id]->getTitle();
        $fields['price'] = $this->store[$id]->getPrice();
        return $fields;
    }

}
