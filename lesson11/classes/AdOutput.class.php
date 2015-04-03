<?php
 class AdOutput
{
    private $ads;
    private $authors;
    private $adToReturn;
    private $cities;
    private $categories;
    private $notice;


     public function __construct($args) 
    {
        static::set($args);
    }
    
    
     public function getAds()
    {
        return $this->ads;
    }
     public function getAuthors()
    {
        return $this->authors;
    }
     public function getAdToReturn()
    {
        return $this->adToReturn;
    }
     public function getCities()
    {
        return $this->cities;
    }
     public function getCategories()
    {
        return $this->categories;
    }
    
    
     public function getAsCheckbox()
    {/*
     * эта функция нужна для вывода в формате {html options}
     */
        if ( ! $this->authors) return NULL;
         foreach ($this->authors as $key => $obj)
        {
             if (!$key==0)
            {
                $array[$key]='Имя:   '.$obj->getName().'   Почта: '.$obj->getMail();
            }
        }
        return $array;
    }
    
     public function set($args)
    {
         foreach($args as $nameOfArg=>$value)
        {
             if (property_exists('AdOutput', $nameOfArg))
            {
                $this->{$nameOfArg} = $value;
            }
        }
       
    }
     public function getNotice() 
    {
        return $this->notice;
    }
}

