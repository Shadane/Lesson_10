<?php
 class StoreCarrier 
{
     private $adStore;
     private $auStore;
     private $cityStore;
     private $ctgsStore;
     private $notice;
     private $adToReturn;
     private $auToReturn;
     
      public function __construct($adStore, $auStore, $cityStore, $ctgsStore) 
     {
         if (! $adStore instanceof AdStore) die('wrong instance of adStore is given');
         $this->adStore= $adStore;
         $this->adStore->loadAll('ads');
         
         if (! $auStore instanceof AuStore) die('wrong instance of auStore is given');
         $this->auStore= $auStore;
         $this->auStore->loadAll('authors');
         
         if (! $cityStore instanceof CityStore) die('wrong instance of cityStore is given');
         $this->cityStore= $cityStore;
         $this->cityStore->loadAll();
         
         if (! $ctgsStore instanceof CtgsStore) die('wrong instance of adStore is given');
         $this->ctgsStore= $ctgsStore;
         $this->ctgsStore->loadAll();
     }
     
      public function getAdStore()
     {
          return $this->adStore;
     }
      public function getAuStore()
     {
          return $this->auStore;
     }
      public function getCityStore()
     {
          return $this->cityStore;
     }
      public function getCtgsStore()
     {
          return $this->ctgsStore;
     }
     
     
      public function setNotice($notice)
     {
          $this->notice = $notice;
     }
      public function getNotice()
     {
          return $this->notice;
     }
      public function setAdToReturn($ad)
     {
          $this->adToReturn = $ad;
     }
      public function getAdToReturn()
     {
          return $this->adToReturn;
     }
      public function setAuToReturn($au)
     {
          $this->auToReturn = $au;
     }
      public function getAuToReturn()
     {
          return $this->auToReturn;
     }
     
     
     
     public function getAuthorsAsCheckbox()
    {/*
     * эта функция нужна для вывода в формате {html options}
     */
         $authors = $this->auStore->getStore();
        if ( ! $authors) return NULL;
         foreach ($authors as $key => $obj)
        {
             if (!$key==0)
            {
                $array[$key]='Имя:   '.$obj->getSeller_name().'   Почта: '.$obj->getEmail();
            }
        }
        return $array;
    }
    
}

