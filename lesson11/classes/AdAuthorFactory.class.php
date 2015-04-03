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
         * но удалять класс из параметров не хочется, т.к удобно смотреть какой именно объект создается в данный момент.
         */
//        require_once $class.'.class.php'; 

        if (!class_exists($class)) {die ('Invalid class given to build an object'); }
        
        foreach ($fields as $id=>$data)
        {
            $objects[$id] = new $class($data);
        }
        return $objects;
    }
    
    public static function buildOne($class ,array $fields)
    {
//        require_once $class.'.class.php';
        if (!class_exists($class)) {die ('Invalid class given to build an object'); }
        
        $object = new $class($fields);
        return $object;
    }
}
