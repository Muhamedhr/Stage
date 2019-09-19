<?php
//je hebt de php code nodig om te connecten dit is een soort verplichte #include
require 'connect_db.php';

//start de sessie
secure_session_start();
 
//check of de gebruiker ingelogd is, zo niet ga terug naar de login page (security)
if(!isset($_SESSION['user_id']) || !isset($_SESSION['logged_in']))
{
	//log dat degene is ingelogd
	$log_succesfull_login_query = "insert into User_action_logs (object_id, employee_number, action_id) values (max(object_id) + 1, {employee number}, {action_id}";
	execute_sql_modify_data($log_succesfull_login_query);
	
	//update het last login veld in de user tabel
	$current_time = time();
	$update_last_login_query = "update User_accounts set last_login" . $current_time . "where user_id = {user_id}";
	execute_sql_modify_data($update_last_login_query);
}

else
{
    //User not logged in -> Redirect them back to the login_page.php page
    header('Location: login.php');
    exit;
}

//ingelogde user krijgt deze te zien
echo 'Congratulations! You are logged in!';
	
//elke keer als er een optie wordt geklikt, wordt deze aangeroepen
function get_data_request_options()
{
	//kijk wat het abstractie niveau is van de huidige opties
	$current_abstraction_level_query = 'select option_type from Requestable_data where option_name == ":current_selected_option"';
	$current_abstraction_level = execute_sql_extract_data($current_abstraction_level_query);
	
	//haal de opties maar op uit de DB
	$requestable_data_descriptions = 'select option_name from Requestable_data where option_type = ' . $current_abstraction_level;
	execute_sql_extract_data($requestable_data_descriptions);
}

//de opgevraagde data wordt weergegeven in een tabel aan de gebruiker
function display_requested_data($query_description)
{
	//als de gebruiker een optie aanklikt, wordt de query die in de database staat uitgevoerd (de query is mogelijk encrypted als dat nodig blijkt te zijn
	$corresponding_sql_query = 'select option_query from Requestable_data where option_name = ' . $query_description;
	$executable_query = execute_sql_extract_data($corresponding_sql_query);
	
	//dit is de data die je wilt zien
	execute_sql_extract_and_display_data($executable_query);
}

//functie om de username en last login te displayen op het scherm
function get_to_be_displayed_user_data($user_id)
{
	//fix deze query nog
	//get username
	$displayed_user_name_query = "select username from User_accounts";
	$displayed_user_name = execute_sql_extract_data($displayed_user_name_query);
	
	//fix deze query nog
	//get last login
	$displayed_last_login_query = "select last_login from User_accounts where id is blablabla";
	$displayed_last_login = execute_sql_extract_data($last_login_query);
	
	return $displayed_user_name, $displayed_last_login;
}

function log_out()
{
	//log dit in de database
	$log_log_out_query = "insert into User_action_logs (object_id, employee_number, action_id) values (max(object_id) + 1, {employee number}, {action_id}";
	execute_sql_modify_data($log_log_out_query);
	
	current_session_secure_regenerate_id();
	
	//redirect naar de login pagina
	header('Location: login_page.html');
	exit();
}

function reset_filters()
{
	//abstractie niveau wordt weer 1
	//uitzoeken of het in js of php gedaan word	
}
	

function select_option()
{
	//moet er nog wat speciaals gebeuren?
}

?>