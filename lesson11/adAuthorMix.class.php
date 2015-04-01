<?php
require_once 'ad.class.php';
class adAuthorMix extends ad
{
    private $seller_name;
    private $email;
    
    public function __construct($postData) {
        parent::__construct($postData);
        $this->seller_name = $postData['seller_name'];
        $this->email = $postData['email'];
        $this->allow_mails =$postData['allow_mails'];
    }
    
    public function getName()
    {
        return $this->seller_name;
    }
    public function getMail() 
    {
        return $this->email;
    }
}

