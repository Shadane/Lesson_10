<?php

 trait MagicGet
{
     public function __get($name) 
    {
        if (property_exists($this, $name))
        {
            $method = 'get'.$name;
            return $this->{$method}();            
        }
    }
}

