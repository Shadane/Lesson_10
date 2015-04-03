<?php

function databaseErrorHandler($message, $info)
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;
    // Выводим подробную информацию об ошибке.
    echo "SQL Error: $message<br><pre>"; 
    print_r($info);
    echo "</pre>";
//    $firephp=$GLOBALS['firephp']; //эта конструкция выдает ошибку хедеров на денвере, поэтому закомментил и вернул старое, на вагранте работает нормально.
//    $firephp->group('SQL ERROR:['.$message.'<br>');
//    $firephp->error($info);
//    $firephp->groupend();

    die('OOPS! There is an error here! <a href="./install.php">Перейти на install</a>');
}

function myLogger($db, $sql, $caller)
{
  $firephp = $GLOBALS['firephp'];
  
  if (isset($caller['file'])){
        $firephp->group("at ".$caller['file'].' line '.$caller['line']);
  }
  $firephp->log($sql);
  if (isset($caller['file'])){
        $firephp->groupend();
  }
}
