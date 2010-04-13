<?php
if (isset($_GET['p2']) && $_GET['p2'] == 'new'){
	include 'cont/playtournament/new_bracket.playtournament.cont.inc.php';
	return;
}

if(isset($_GET['p2']) && is_numeric($_GET['p2'])){
	

	$_SESSION['bracket_id'] = $_GET['p2'];
	
	$bracket = new bracket();
	$bracket->load_entry($_SESSION['bracket_id']);
	
	if (isset($_GET['p3']) && $_GET['p3']=='delete'){
		
		if (isset($_GET['p4']) && $_GET['p4'] == 1){
			$bracket->delete($_SESSION['bracket_id']);
			header("Location: ".BASE."/play_tournament/".$_SESSION['tournament_id']);
		}else{
			echo '
				<input type="hidden" name="delete" value="1" />
				Warning! This will delete all matches and corresponding results belonging to this bracket and can\'t be undone.<br />
				<a href="'. $_SERVER['REQUEST_URI'] .'/1">Yes, I am sure. Proceed</a>
			';
		}
		return;
	}
	
	$status = $bracket->get_status();
	
	switch ($status){
		case 1:
			$_SESSION['temp']['bracket']['nextstep'] = 2;
			$_SESSION['temp']['bracket']['bracket_id'] = $_SESSION['bracket_id'];
			include 'cont/playtournament/new_bracket.playtournament.cont.inc.php';
			return;
		break;
		
		case 2:
			$_SESSION['temp']['bracket']['nextstep'] = 3;
			$_SESSION['temp']['bracket']['bracket_id'] = $_SESSION['bracket_id'];
			include 'cont/playtournament/new_bracket.playtournament.cont.inc.php';
			return;
		break;
		
		case 3:
			$_SESSION['temp']['bracket']['nextstep'] = 4;
			$_SESSION['temp']['bracket']['bracket_id'] = $_SESSION['bracket_id'];
			include 'cont/playtournament/new_bracket.playtournament.cont.inc.php';
			return;
		break;

	}

	
}else{
	header("Location: ".BASE."/play_tournament/".$_SESSION['tournament_id']);
	return;
}



$class = new bracket();
$class->load_entry($_SESSION['bracket_id']);
$bracket_type = $class->get_bracket_type();

$bracket = new $bracket_type();
$bracket->load_entry($_SESSION['bracket_id']);

$bracket->draw_ranklist();



?>