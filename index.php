<?php
require_once "common.php";
// session is started in common.php

error_reporting(E_ALL);
ob_start();

switch ($_GET['cat']) {
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

$xsltProc = new XSLTProcessor();
$xsltProc->importStylesheet(DOMDocument::load("xsl/main.xsl"));

$dataDoc = DOMDocument::loadXML("<page><ob-content>{$contents}</ob-content></page>");
echo $xsltProc->transformToXml($dataDoc);
