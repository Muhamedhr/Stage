<?php
session_start();

//als de database conection niet include kan worden dan kan je ook niet inloggen...
//include 'connect_db.php';
echo "test1";
$HOST = "localhost";
$USER = "root";
$PASSWD = "rootrootroot12345";
$DBNAME = "test";
echo "test2";

try
{
	$pdo_options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);
	$connection = new PDO("mysql: host=" . $HOST . ";dbname=" . $DBNAME, $USER, $PASSWD, $pdo_options);
	echo "connected to DB";
}
catch(PDOException $e)
{
	print "Error!: " . $e->getMessage();
	echo "not connected";
	die();
}

echo "test4";
$uname_attempt = $_POST['username'];
$passwd_attempt = $_POST['passwd'];

$hash = 'sha256';
$pass_hash = hash($hash, $passwd_attempt);

if(isset($_POST['login']))
{
//echo "hallo test";
echo "<script>console.log('testje in de log');</script>";
	if(!empty($passwd_attempt))
	{
		if(!empty($uname_attempt))
		{

			//print "voor de statement";
			try
			{
				echo "<script>console.log('voor het uitvoere');</script>";
				$statement = $connection->prepare("select * from Users where uname = :uname_attempt");
				$statement->bindParam(':uname_attempt', $uname_attempt, PDO::PARAM_STR);
				$statement->execute();
				$result = $statement->fetchAll(PDO::FETCH_ASSOC);
				$result = json_encode($result);
				echo "uitgevoerd";
				echo $result;
			}

			catch(PDOException $e)
			{
				echo "<script>console.log('error executing sql');</script>";// . $e->getMessage();
			}

			$user_passwd = $result[0]['passwd'];
			
			//check het wachtwoord nu maar
			if(password_verify($pass_hash, $user_passwd)
			{
				echo "login succes!";
				header('Location: ../main_page.html');
			}

			else
			{
				echo "login failed";
			}

/*
			//normaal hier in de databae checken
			if($uname_attempt === 'hoi' && $passwd_attempt === 'adminpasswd')
			{
				echo "hallo test";
				header('Location: ../main_page.html');
			}

			else
			{
				echo $uname_attempt . $passwd_attempt;
			}
*/
		}

		else
		{
			echo 'No username';
		}
	}

	else
	{
		echo 'No passwd';
	}
}

?>
