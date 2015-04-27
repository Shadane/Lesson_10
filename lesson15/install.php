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



     if (is_file('./L15.php')) 
    {
        $data = '<div class="text-center"><a href=./L15.php class="btn btn-primary btn-lg">Перейти на страницу с Объявлениями</a></div>';
    }
}
?>
<html>
    <HEAD>
      <TITLE>install 15</TITLE>
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css">

      <!-- Optional theme -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap-theme.min.css">

   </HEAD>
   <body>
        <div class="container col-lg-5 col-md-8 col-sm-8 col-lg-offset-3 col-md-offset-1 col-sm-offset-1"> 
            <br />
            <br />
       <?php
            if(isset($data)) {exit($data);}
       ?>
       
    <form class="form-horizontal" method="post">
        
                 <h1 class="text-center"> Введите данные для записи в БД</h1>
            <div class="form-group has-success">
                <label for="server_name">Server name:</label></br>
                <input class="form-control" type="text" id="server_name" name="server_name">
            </div>
            </br></br>
         <div class="form-group has-success">
            <label for="user_name">User name:</label></br>
            <input class="form-control" type="text" id="user_name" name="user_name">
         </div>
            </br></br>
         <div class="form-group has-success">
             <label for="password">Password:</label></br>
             <input type="password" class="form-control" id="password" type="text" name="password">
         </div>
             </br></br>
            <div class="form-group has-success">
                <label for="database">Database:</label></br>
                <input class="form-control" type="text" id="database" name="database">
            </div>
             </br></br>
              <div class="form-group text-center">
                <input class="btn btn-primary" type="submit" name="install" value="Установить таблицу в базу данных">
              </div>
       </div>
    </form>
   </body>
</html>