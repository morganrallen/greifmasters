<?php
//if (isset($_GET['team_id']) && is_numeric(htmlentities($_GET['team_id']))){
//	$team_id = htmlentities($_GET['team_id']);
//	$_SESSION['team_id'] = $team_id;
//}elseif(isset($_SESSION['team_id'])){
//	$team_id = $_SESSION['team_id'];
//}
//else{
//	$_SESSION['notification']=2;
//	header ( "Location: /greifmasters/admin/tournament/$tournament->id/" );
//	break;
//}


	// load tournament -------------------------------------------------------

//	$tournament = new tournament();
//	try{
//		$tournament->load_tournament($tournament_id);
//	}catch (Exception $exception){
//			echo 'Error: '.$exception -> getMessage().'<br />';
//			echo tournaments_table();
//	}


	// actions ----------------------------------------------------------------

	if( isset ($_GET ['p1']) && $_GET ['p1'] == 'show') {
		include 'cont/inc/show_team.cont.inc.php';
		return;
	}
	
	
	
	
	if( isset ($_GET ['p1']) && $_GET ['p1'] == 'create') {
		
		include 'cont/inc/create_team.cont.inc.php';
		
		return;
	}
	


	// display info -------------------------------------------------------



	include 'cont/inc/tables/existing_teams.table.inc.php';
	
	


?>