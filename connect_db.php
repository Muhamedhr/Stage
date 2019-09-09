<?php

//de PHP code voor het inlog scherm
//dingen toevoegen die guido ook had, voor extra beveiliging

//variabelen
$HOST = "localhost";
$USER = ""
$PASSWD = "";
$DBNAME = "hesb";

//opties voor pdo/ configuratie details
$pdo_options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);

//met deze kan je nu met de database connecten
$connection = new PDO(
    "mysql:host=" . HOST . ";dbname=" . DBNAME, //DSN
    USER, //Username
    PASSWD, //Password
    $pdo_options //Options
);

?>