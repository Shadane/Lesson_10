<?php
require_once 'adAuthorMix.class.php';
/* 
 * создал отдельный класс на случай 
 * если понадобится что-то менять в нем.
 */
class placeholder extends adAuthorMix
{
    
    public function __construct($fields) 
    {
        parent::__construct($fields);
    }

}

