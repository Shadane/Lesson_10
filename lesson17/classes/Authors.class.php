<?php
 class Authors
{
    private $seller_name;
    private $email;
//    use MagicGet; не работает на Denwer, т.к там 5.3 а не 5.4 пхп
    
     public function __construct(array $data) 
    {
        $this->seller_name = $data['seller_name'];
        $this->email = $data['email'];
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
    
     public function getEmail()
    {
        return $this->email;
    }
     public function getSeller_name()
    {
        return $this->seller_name;
    }
    
    
    
     public function setName($name)
    {
        $this->seller_name = $name;
    }
    
//     public function getAsArray()
//    {
//         return get_object_vars($this);
//    }
    
    
}



