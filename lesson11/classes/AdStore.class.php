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
     * содержит обе сущности. Сделать иначе достаточно проблематично пока классы
     * не знают друг о друге.
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
        $adToReturn = adAuthorFactory::buildOne('adToReturn', $fields);
        return $adToReturn;
    }

}
