<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf8');



if (isset($_POST['install'])) {
    // Подключаем библиотеки.
    $project_root = dirname(__FILE__);
    require_once $project_root . "/dbsimple/config.php";
    require_once $project_root . "/dbsimple/DbSimple/Generic.php";

    require_once $project_root . '/FirePHPCore/FirePHP.class.php';

    require_once $project_root . '/includes/dbsimple+firephp.inc.php';

    require $project_root . '/includes/Autoload.inc.php';



    $firephp = firephp::getInstance(true);
    $firephp->setEnabled(true);


    $install = new install($_POST);
    $install->buildTables();




     if (!is_dir('./smarty/templates')) 
    {
        mkdir('./smarty/templates');
    }


     if (is_file('./L11.tpl')) 
    {
        copy('./L11.tpl', './smarty/templates/L11.tpl') or die('не удалось переместить файл шаблона');
    }


     if (is_file('./L11.php')) 
    {
        exit('<div style="width: 300px;align= right"><a href=./L11.php>Success!lesson 11 homework</a></div>');
    }
}
?>
<html>
    <form style="" method="post">
        <label>Server name:</label></br>
        <input type="text"  name="server_name">
        </br></br>
         <label>User name:</label></br>
        <input type="text" name="user_name">
        </br></br>
         <label>Password:</label></br>
        <input type="text" name="password">
        </br></br>
         <label>Database:</label></br>
        <input type="text" name="database">
        </br></br>
        <input type="submit" name="install" value="Установить таблицу в базу данных">
    </form>
</html>