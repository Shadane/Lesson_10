<?php

spl_autoload_register(function ($class) 
{
    if (is_file('classes/' . $class . '.class.php'))
    {
        require 'classes/' . $class . '.class.php';
    }
    
    if (is_file('traits/' . $class . '.trait.php'))
    {
        require 'traits/' . $class . '.trait.php';
    }

}
                                        );

