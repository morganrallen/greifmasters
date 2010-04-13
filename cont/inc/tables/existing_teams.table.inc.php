<table class="t1">
	<tr>
		<th>Name</th>
		<th>City</th>
		<th>Players</th>
	</tr>
	
	
<?php	
	$query = "
			SELECT

				t.name AS name,
				t.city AS city,
				t.player1 AS player1_id,
				t.player2 AS player2_id,
				t.player3 AS player3_id,
				p1.name AS player1_name,
				p2.name AS player2_name,
				p3.name AS player3_name

			FROM
				teams AS t
			INNER JOIN players AS p1 ON t.player1 = p1.id
			INNER JOIN players AS p2 ON t.player2 = p2.id
			INNER JOIN players AS p3 ON t.player3 = p3.id
		";
	
	#@todo: query should be done in the team class

		$result = mysql_query ( $query ) or die ( mysql_error () );

		if (mysql_affected_rows () == 0) {
			echo end_table(3);
		}
		
		while($data = mysql_fetch_assoc($result)){
			
					echo'
				<tr>
					<td>'.$data['name'].'</td>
					<td>'.$data['city'].'</td>
					<td>'.$data['player1_name'].', '.$data['player2_name'].', '.$data['player3_name'].'</td>
				</tr>
		';
			
			
		}
		mysql_free_result($result);
		

echo '</table>
		';

?>