<?php
 class Ad extends Ads
{
    protected $private;
    protected $allow_mails;
    protected $phone;
    protected $location_id;
    protected $category_id;
    protected $description;
    protected $return_id;
    
     public function __construct($postData) 
    {
        parent::__construct($postData);

        $this->private     =   $postData['private'];
        $this->allow_mails =   isset($postData['allow_mails']);
        $this->phone       =   $postData['phone'];
        $this->location_id =   $postData['location_id'];
        $this->category_id =   $postData['category_id'];
        $this->description =   $postData['description'];
        $this->return_id   =   $postData['return_id'];
    }
    
     public function getReturn_id()
    {
     return $this->return_id;
    }
     public function getPrivate()
    {
     return $this->private;
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
        unset($adAsArray['return_id']);
        return $adAsArray;
    }
}

