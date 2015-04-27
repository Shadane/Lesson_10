<?php

/*
 * в случае buildmany - прямиком из базы данных подгружается 
 * массив fields сюда, а также название класса, по названию класса 
 * реквайрим класс.пхп и раскручиваем массив со строками из БД, создавая из каждой строки по объекту
 * 
 * в случае с buildone - передается массив со значениями (like seller_name => 'im seller')
 * и создается новый объект из этих полей. Пока писал - понял что и buildone то не особо нужен, но пока не буду менять.
 */
 class AdAuthorFactory
{
     public static function buildmany($class, array $fields)
    {
        /*
         * в связи с добавленным автолоадером require уже и не нужен
         */
//        require_once $class.'.class.php'; 

         if (!class_exists($class)) 
        {
             die ('Invalid class given to build an object'); 
        }
        
         foreach ($fields as $id=>$data)
        {
            
            $objects[$id] = new $class($data);
        }
        return $objects;
    }
    /*
     * понимаю, что эту фабрику лучше расширять, а не лепить условия 
     * как сделано в buildone, может позже сделаю))
     */
     public static function buildOne($class ,array $fields)
    {
//        require_once $class.'.class.php';
         
        
         if ($class=='ad'||$class=='ads')
        {
             $classModifier = ($fields['private']==0)? 'Private' : 'Company';
             $class= $classModifier.$class;
             
        }
        
        if (!class_exists($class)) 
        {
             die ('Invalid class given to build an object:<h1> '.$class.' </h1>with such fields: '.  var_dump($fields)); 
        }

        $object = new $class($fields);
        return $object;
    }
}
