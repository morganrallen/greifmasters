<?php
if (isset ( $_POST ['submit'] )) {

	$team_name = $_POST['team_name'];
	$city = $_POST['city'];
	$player1 = $_POST['player1'];
	$player2 = $_POST['player2'];
	$player3 = $_POST['player3'];	
	
	
	$team = new team();
	
	$team->store($team_name, $player1, $player2, $player3, $city);
	

	
	if (isset ($_SESSION['quick_add_team_to'])){
		#@todo: seems to be a stupid way. how to add teams? does this file make sense as it is now?
		$registration = new registration ();
		$registration->store($team->get_id(), $_SESSION['quick_add_team_to']);
		header ( "Location: ".BASE."/tournament/" . $_SESSION['quick_add_team_to']);
		unset($_SESSION['quick_add_team_to']);
		
	}else{
			header ( "Location: ".BASE."/teams/show/" . $team->insert_id);
	}
	

} else {
	include 'inc/forms/create_team.form.inc.php';
	return;
}
		
?>