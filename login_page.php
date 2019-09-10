<?php 
//start een sessie, deze MOET aangeroepen worden op elke pagina
session_start();

//je hebt de php code nodig om te connecten dit is een soort verplichte #include
require 'connect_db.php';

//pak de waarden van de login velden
//de lijn is op te vatten als -> if username !empty then trim(ussername) else null;
$username = !empty($_POST['username']) ? trim($_POST['username']) : null;
$passwdAtt = !empty($_POST)['passwd']) ? trim($_POST['passwd']) : null;
$hash = "sha512";

//functie om the checken of de login valid is
function isValidLogin($username, $passwd)
{	
	//de sql query om de velden the checken
	$query = "select user_id, username, passwd from users where username = :username"
	$statement = $pdo->prepare($query);
	$query->bindValue(':username', $username);
	
	//execute en fetch
	$statement->execute();
	$result = $statement->fetch(PDO::FETCH_ASSOC);
	
	//checken of de user uberhaupt bestaat
	if($result === false)
	{
		die('incorrecte gebruikersnaam / wachtwoord combinatie');
	}
	else
	{
		//de user bestaat, check nu of het wachtwoord klopt
		//vergelijk de wachtwoorden met elkaar, "$user['passwd']" is het gehashte wachtwoord in de database
		$validPasswd = password_verify(hash("sha512", $passwd), $user['passwd']);
		
		//als het wachtwoord geldig is
		if($validPasswd)
		{
			//maak een sessie id voor de gebruiker
			$_session['user_id'] = $user['id'];
			$_session['logged_in'] = time();
			
			//redirect naar de main_page.html
			header('Location: \\central.local\sitestorage\Belgium_Home\Mumamed Agic\Stage_project\code\Stage-master\Stage-master\main_page.html');
		}
		else
		{
			die('incorrecte gebruikersnaam / wachtwoord combinatie');
		}
	}
}

//als het inloggen geprobeerd wordt
if(isset($_POST['login']))
{
	//check of de login valid is
	if(isValidLogin($VBUNAME, $UNHASHEDPASSWD))
	{
		echo "login gelukt";
		exit();
	}
	else
	{
		echo "login failed";
	}
}

?>