<?php

class notice
{
    private $notice_field;
    function __construct(array $notice_field) 
    {
        $this->notice_field = $notice_field['notice_field'];
    }
    
    public function getNotice()
    {
        return $this->notice_field;
    }
}

