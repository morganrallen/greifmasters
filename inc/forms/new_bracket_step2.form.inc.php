<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="2" />
<table>
	<tr>
		<td colspan="2">seeding: assign numbers to the teams. Strongest team(s) get lowest numbers. Eqal strong teams get same numbers. Not specifying a number means team will be assigned randomly.</td>
	</tr>
	<tr>
		<td>Team name</td>
		<td>postion on "clock"</td>
	</tr>
	
	<?php 
	
	$registration = new registration();
	$registered = $registration->get_registered_teams($_SESSION['tournament_id']);
	
	foreach ($registered as $team){
		echo '
			<tr>
				<td>'.$team['name'].'</td><td>
		';
	}
	
	
	?>


</table>


</form>