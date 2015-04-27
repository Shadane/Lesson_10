<?php
require_once 'init.php';


$storeCarrier = new StoreCarrier(new Adstore, new AuStore, new CityStore, new CtgsStore);

if ( isset($_GET['delentry']) && is_numeric($_GET['delentry']) ) 
   {           //delete button
             $storeCarrier->getAdStore()->delete($_GET['delentry']);
   }