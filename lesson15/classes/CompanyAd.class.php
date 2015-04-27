<?php
 class CompanyAd extends CompanyAds
{
     /*
      * не запускается на денвере, там ниже чем 5.4 версия
      * поэтому дублируется код в двух классах.
      */
//   use AdTemplate, MagicGet;
//   
//      public function __construct(array $postData) {
//       $this->__atconstruct($postData);
//   }
   
    protected $allow_mails;
    protected $phone;
    protected $location_id;
    protected $category_id;
    protected $description;
    protected $id;
    
     public function __construct(array $postData) 
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
    
        /*
     * функция __get дублируется, т.к изначально использовал трейт, а на денвере он не запустился.
     */
     public function __get($name) 
    {
        if (property_exists($this, $name))
        {
            $method = 'get'.$name;
            return $this->{$method}();            
        }
    }
}

