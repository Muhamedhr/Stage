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

//functie om een sql statement uit te voeren voor data opvraag(don't repeat yourself)
//deze wordt niet gebruikt bij het inloggen, omdat er bij het inloggen een extra parameter meegegeven moet worden
function execute_sql_extract_data($query)
{
	//meest efficiente/geschikte codering uitzoeken
	$statement = $pdo->prepare($query);
	try
	{
		$statement->execute();
		$result = $statement->fetch(PDO::FETCH_ASSOC);
		echo $result;
	}
	catch (PDOException $e)
	{
		echo "Extracting data failed" . $e->getMessage();
	}
}

//modifyen houdt hier in -> inserten, updaten, modifyen en deleten
//nieuwe functie omdat je bij het modifyen van de DB (inserten, updaten, modifyen en deleten) de exec() functie nodig hebt
function execute_sql_modify_data($query)
{
	$statement = $pdo->prepare($query);
	try
	{
		$statement->exec();
		$pdo->commit();
	}
	catch (PDOException $e)
	{
		echo "Inserting data failed" . $e->getMessage();
	}
}

?>