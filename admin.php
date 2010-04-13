<?php
require_once "common.php";

#FIXME: not one single form is checked. neither if it is completed, nor if it contains forbidden characters. xss, sql-inj, ... !!

error_reporting(E_ALL);
session_start ();

#debug mode below
$_SESSION['admin']=TRUE;
$_SESSION['user'] = 2;

if (! isset ( $_SESSION ['admin'] ) || $_SESSION ['admin'] != TRUE) {
	header ( "Location: login.php" );
	exit ();
}

if (isset ( $_GET ['logout'] ) && $_GET ['logout'] == 1) {
	session_destroy ();
	header ( "Location: $_SERVER[PHP_SELF]" );
	exit ();
}

ob_start();

if (isset($_SESSION['notification'])){

	echo notifications($_SESSION['notification']);
	unset ($_SESSION['notification']);

}

if (isset ( $_GET ['cat'] )) {
	$_SESSION ['cat'] = htmlentities($_GET['cat']);
}else{
	$_SESSION ['cat'] = '';
}

$navigation = '';

switch ($_SESSION['cat']) {
	case 'rpc' :
		include 'rpc.php';
		$noTemplates = true;
	break;

	case 'list_tournaments' :
		include 'cont/list_tournaments.cont.php';
	break;

	case 'tournament' :
		include 'cont/tournament.cont.php';
	break;

	case 'teams' :
		include 'cont/teams.cont.php';
	break;

	case 'team' :
		include 'cont/team.cont.php';
	break;

	case 'courts' :
		include 'cont/courts.cont.php';
	break;
		
	case 'settings' :
		include 'cont/settings.php';
	break;

	case 'setup' :
		include 'cont/setup.cont.php';
	break;

	case 'play_tournament':
		include 'cont/play_tournament.cont.php';
		$navigation = 'play_tournament.navigation.tpl.php';
	break;

	case 'logout':
		session_destroy();
		header ( "Location: ../login.php" );
	break;
	
	case 'test_code':
		include 'test_code.php';
	break;

	default :
		include 'cont/general.php';
	break;

}



$contents = ob_get_contents();
ob_end_clean();

if(!$noTemplates) {
	echo"get: "; var_dump ($_GET);echo"<br>";
	echo"post: "; var_dump ($_POST);echo"<br>";
	echo"session: "; var_dump ($_SESSION);echo"<br>";


	include TPL_INCLUDE_PATH . 'head.tpl.php';

	if ($navigation != '') {
		include TPL_INCLUDE_PATH . $navigation;
	}else{
		include TPL_INCLUDE_PATH . 'navigation.tpl.php';
	}

	echo '<div id="contentContainer">';
}

echo $contents;

if(!$noTemplates)
{
	echo '</div>';
	include TPL_INCLUDE_PATH . 'bottom.tpl.php';
}
?>
