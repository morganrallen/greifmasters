<?php
parse_str($_POST['data']);
mysql_connect('localhost', 'root');
mysql_select_db('greifmasters');

for ($i = 0; $i < count($ajax_list); $i++) {
	if(is_int($i)) {
		mysql_query("UPDATE seeding SET value = '$i' WHERE team_id = '$ajax_list[$i]'");
		#zu updaten: team_id
	}
	else {
	exit;
	}
}
?>