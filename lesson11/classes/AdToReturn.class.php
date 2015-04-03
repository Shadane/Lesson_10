<?php
 class AdToReturn extends Ad
{
    private $seller_name;
    private $email;
    
     public function __construct($postData) 
    {
        parent::__construct($postData);
        $this->seller_name = $postData['seller_name'];
        $this->email = $postData['email'];
        $this->allow_mails =$postData['allow_mails'];
    }
    
     private function getSeller_name()
    {
        return $this->seller_name;
    }
     public function getEmail() 
    {
        return $this->email;
    }
    /*
     * функция для вывода через смарти.
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

