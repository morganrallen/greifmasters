<?php

if (isset($_GET['p2']) && is_numeric($_GET['p2'])){

	$id = $_GET['p2'];


	$team = new team();

	$team->load_entry($id);
	
	$name = $team->get_name();
	$city = $team->get_city();
	$players = $team->get_players();
	
		echo'
			<table>
				<tr>
					<td>'.$name.'</td>
					<td>'.$city.'</td>
					<td>'.$players[player1].', '.$players[player2].', '.$players[player3].'</td>
				</tr>
			</table>
		';


}


?>