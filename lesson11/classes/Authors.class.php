<?php
class Authors
{
    private $seller_name;
    private $email;
    
    public function __construct(array $data) 
    {
        $this->seller_name = $data['seller_name'];
        $this->email = $data['email'];
    }
    
    
    public function getMail(){
        return $this->email;
    }
    public function getName(){
        return $this->seller_name;
    }
    
    
    
    public function setName($name)
    {
        $this->seller_name = $name;
    }
}



