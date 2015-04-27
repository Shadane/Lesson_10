<?php
class CompanyAds extends Ads
{
    protected $private;
    function __construct(array $postData) {
        parent::__construct($postData);
        $this->private     =   $postData['private'];
    }
    
     public function getPrivate()
    {
     return $this->private;
    }
}