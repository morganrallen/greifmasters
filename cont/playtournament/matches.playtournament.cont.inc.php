<?php

#@todo: doesn't need to be an own file (as many more half empty files)

if (isset ( $_GET ['p2'] ) && ($_GET ['p2'] == 'upc' || $_GET ['p2'] == 'fin')) {
	include 'inc/lists/matches.list.inc.php';
	
}



if (isset ( $_GET ['p2'] ) && $_GET ['p2'] == 'ong') {
	include 'cont/playtournament/upnow.playtournament.cont.inc.php';
	
}




?>
