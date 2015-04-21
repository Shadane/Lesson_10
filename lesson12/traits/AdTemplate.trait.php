<?php

trait AdTemplate
{
    protected $allow_mails;
    protected $phone;
    protected $location_id;
    protected $category_id;
    protected $description;
    protected $id;
    
     public function __atconstruct(array $postData) 
    {
        parent::__construct($postData);
        $this->allow_mails =   isset($postData['allow_mails']);
        $this->phone       =   $postData['phone'];
        $this->location_id =   $postData['location_id'];
        $this->category_id =   $postData['category_id'];
        $this->description =   $postData['description'];
        $this->id   =   $postData['id'];
        
    }
    
     public function getId()
    {
     return $this->id;
    }
     public function getAllow_mails()
    {
     return $this->allow_mails;
    }
     public function getPhone()
    {
     return $this->phone;
    }
     public function getLocation_id()
    {
     return $this->location_id;
    }
     public function getCategory_id()
    {
     return $this->category_id;
    }
     public function getDescription()
    {
     return $this->description;
    }
    
    
     public function getAsArray()
    {
        $adAsArray = get_object_vars($this);
//        unset($adAsArray['return_id']);
        return $adAsArray;
    }
     public function setId($id)
    {
         $this->id = $id;
    }
}


