<?php
//start de sessie
session_start();
 
//check of de gebruiker ingelogd is, zo niet ga terug naar de login page (security)
if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']))
{
    //User not logged in -> Redirect them back to the login_page.php page
    header('Location: login.php');
    exit;
}

//ingelogde user krijgt deze te zien
echo 'Congratulations! You are logged in!';

function get_possible_data_request_options()
{
	$query = "select * from Requestable_data where option_type = 1";
	execute_sql_extract_data($query);
}

?>