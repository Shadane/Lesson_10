<?php
class adOutput
{
    private $ads;
    private $authors;
    private $adToReturn;
    private $cities;
    private $categories;
    private $notice;


    public function __construct($ads, $authors, $adToReturn, $cities, $categories) 
    {
        $this->adToReturn = $adToReturn;
        $this->authors = $authors;
        $this->ads = $ads;
        $this->cities = $cities;
        $this->categories = $categories;
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
    
    public function setNotice($notice)
    {
        $this->notice = $notice;
    }
    public function getNotice() 
    {
        return $this->notice;
    }
}

