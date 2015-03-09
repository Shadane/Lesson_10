<?php
error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
ini_set('display_errors', 1);
header('Content-type: text/html; charset=utf8');



if (isset($_POST['install'])){
// Подключаем библиотеки.
$project_root=  dirname(__FILE__);
require_once $project_root."/dbsimple/config.php";
require_once $project_root."/dbsimple/DbSimple/Generic.php";

require_once $project_root.'/FirePHPCore/FirePHP.class.php';
$firephp=firephp::getInstance(true);
$firephp->setEnabled(true);
require_once $project_root.'/dbsimple+firephp.inc.php';

    $contents='<?php '."\r\n".' '
            . '$config_arr = array('."\r\n".''
            . '\'server_name\'=> \''.$_POST['server_name'].'\','."\r\n".''
            . '\'user_name\' => \''.$_POST['user_name'].'\','."\r\n".''
            . '\'password\'=> \''.$_POST['password'].'\','."\r\n".''
            . '\'database\' => \''.$_POST['database'].'\');';
    
    file_put_contents('./config.php', $contents);
    
    $config_arr = config();
    $ads_db = dbconnect($config_arr);
    
//обработчик файла .sql
//нагло стырил с stack overflow, очень понравилось как сделано)

// Read in entire file
if (!file_exists('./ads.sql')){
    die('Cannot locate file to parse tables');
}
// Temporary variable, used to store current query
$templine = '';
$lines = file('./ads.sql');
// Loop through each line
foreach ($lines as $line)
{
    // Skip it if it's a comment
    if (substr($line, 0, 2) == '--' || $line == '')
         continue;

         // Add this line to the current segment
         $templine .= $line;
         // If it has a semicolon at the end, it's the end of the query
         if (substr(trim($line), -1, 1) == ';')
         {
             // Perform the query
                $ads_db->query($templine);
             // Reset temp variable to empty
                $templine = '';
}

}
if (!is_dir('./smarty/templates')){
mkdir('./smarty/templates');
}


if (is_file('./L10.tpl')){
copy('./L10.tpl', './smarty/templates/L10.tpl') or die('не удалось переместить файл шаблона');
}


if (is_file('./L10.php')){
exit ('<div style="width: 300px;align= right"><a href=/L10.php>Success!lesson 10 homework</a></div>');

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