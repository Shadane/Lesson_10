<?php
/* 
 * этот класс только описывает дочерние.
 * Обратите внимание на функцию LoadAll,
 * она принимает из дочерних классов parent::LoadAll имя класса и поля и отправляет их на фабрику.
 */
 abstract class Store
{
    protected $ads_db;
    protected $store;
    
     function __construct()
    {
        $this->ads_db = DBsingleton::getInstance();  
    }
    /*
     * loadall тоже можно сделать абстрактной
     */
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
        //для городов и категорий пока не делал, теоретически ее можно сделать abstract
    }
    
}

    


