<?php
function config(){
    include './config.php';
    if (!isset($config_arr)){
        die ('No userdata, try checking config.php');
    }
    return $config_arr;
}

function dbconnect($config_arr)
{
    $ads_db = DbSimple_Generic::connect("mysqli://".$config_arr['user_name'].":".$config_arr['password']."@".$config_arr['server_name']."/".$config_arr['database']."");
    if (!is_object($ads_db)){ die('CONNECTION PROBLEM'); }
    $ads_db->setErrorHandler('databaseErrorHandler');
    //логирование
    $ads_db->setLogger('myLogger');
    return $ads_db;
}

function databaseErrorHandler($message, $info)
{
    // Если использовалась @, ничего не делать.
    if (!error_reporting()) return;
    // Выводим подробную информацию об ошибке.
    $firephp=$GLOBALS['firephp'];
    $firephp->group('SQL ERROR:['.$message.'<br>');
    $firephp->error($info);
    $firephp->groupend();

    exit('OOPS! There is an error here! <a href="./l10.php">Перейти на главную</a>');
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
