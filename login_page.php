<?php
//je hebt de php code nodig om te connecten dit is een soort #include
require 'connect_db.php';

//start een sessie, deze MOET aangeroepen worden op elke pagina
session_start();

//als het inloggen geprobeerd wordt
if(isset($_POST['login']))
{
	//alles ff checken
	echo "hoi je hebt op login gedrukt";
}

?>