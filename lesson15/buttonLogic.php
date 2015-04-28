<?php
require_once 'init.php';


$adStore = new AdStore();
$adStore->loadAll('ads');

if ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) 
   {           //delete button
             $adStore->delete($_GET['delentry']);
   }