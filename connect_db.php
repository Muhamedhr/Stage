<?php
//de PHP code voor de DB connectie, met wat handige functies

//variabelen
$HOST = "htv000874";
$USER = "hesbowner"
$PASSWD = "mag ik niet weten van dbeaver";
$DBNAME = "hesb";

//opties voor pdo / configuratie details
$pdo_options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_EMULATE_PREPARES => false);

//met deze kan je nu met de database connecten
$connection = new PDO("mysql:host=" . HOST . ";dbname=" . DBNAME, USER, PASSWD, $pdo_options);

//secure versie van sessio_start()
function secure_session_start()
{
	//enable strict session mode, security improvement
	ini_set('session.use_strict_mode', 1);
	session_start();
	
	//je mag een niet te oude session ID hebben
	if(!empty($_SESSION['deleted_time']) && $_SESSION['deleted_time'] < time() - 180)
	{
		session_destroy();
		ini_set('session.use_strict_mode', 1);
		session_start();
	}
}

// Session ID must be regenerated when:
//  - User logged in
//  - User logged out
//  - Certain period has passed
function current_session_secure_regenerate_id()
{
	if(session_status() != PHP_SESSION_ACTIVE)
	{
		secure_session_start();
	}
	
	//zo niet, dan...
	$new_session_id = session_create_id('weet ik veel');
	// Set deleted timestamp. Session data must not be deleted immediately for reasons.
    $_SESSION['deleted_time'] = time();
    // Finish session
    session_commit();
	// Make sure to accept user defined session ID
    // NOTE: You must enable use_strict_mode for normal operations.
	ini_set('session.use_strict_mode', 0);
    // Set new custom session ID
    session_id($newid);
    // Start with custom session ID
    session_start();
}

//functie om een sql statement uit te voeren voor data opvraag(don't repeat yourself)
//deze wordt niet gebruikt bij het inloggen, omdat er bij het inloggen een extra parameter meegegeven moet worden
function execute_sql_extract_data($query)
{
	//meest efficiente/geschikte codering nog uitzoeken
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

//de data displayen in een tabel aan de gebruiker
//algemene versie, je hoeft hier niet alle colommen als parameter mee te geven
function execute_sql_extract_and_display_data($query)
{
	$data = execute_sql_extract_data($query);
	
	//we maken er een table van en geven dat weer
	//key en var???
	$output = '<table id = "table_data_preview" style = "width:100%">';
	foreach($data as $key => $var) 
	{
		
		//$output .= '<tr>';
		if($key === 0) 
		{
			$output .= '<tr>';
			
			foreach($var as $col => $val) 
			{
				$output .= "<td>" . $col . '</td>';
			}
			
			$output .= '</tr>';
			foreach($var as $col => $val) 
			{
				$output .= '<td>' . $val . '</td>';
			}
			
			$output .= '</tr>';
		}
			
		else 
		{
			$output .= '<tr>';
			
			foreach($var as $col => $val) 
			{
				$output .= '<td>' . $val . '</td>';
			}
			
			$output .= '</tr>';
		}
	}
	$output .= '</table>';
	echo $output;
}


//om te testen, algemene sql execute functie
//wacht, maar er wordt niks in de database gezet dus die gebruiken we voor nu niet
/*
function execute_sql($query)
{
	$statement = $pdo->prepare($query);
	try
	{
		if( (strpos($query, 'insert') === true) || (strpos($query, 'update') === true) || (strpos($query, 'delete') === true)
		{
			$statement->exec();
			$pdo->commit();
		}
		
		else
		{
			$statement->execute();
			$result = $statement->fetch(PDO::FETCH_ASSOC);
			echo $result;
		}
	}
	
	catch(PDOException)
	{
		echo "something went wrong" . $e->getMessage();
	}
}
*/
	
?>