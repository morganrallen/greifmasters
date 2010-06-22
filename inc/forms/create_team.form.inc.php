<form method="post" action="index.php?cat=teams&amp;p1=create">


<input type="hidden" name="submit" value="1" />
<?php 
if (isset($_SESSION['quick_add_team_to'])){echo '<input type="hidden" name="add_to" value="'.$_SESSION['quick_add_team_to'].'" />';}
?>

<table>
	<tr>
		<td>Team name:</td>
		<td><input type="text" name="team_name" /></td>
	</tr>
	<tr>
		<td>City:</td>
		<td><input type="text" name="city" /></td>
	</tr>
	<tr>
		<td>Player 1:</td>
		<td><input type="text" name="player1" /></td>
		<td>Email: <input type="text" name="player1email" /></td>
	</tr>
	<tr>
		<td>Player 2:</td>
		<td><input type="text" name="player2" /></td>
		<td>Email: <input type="text" name="player2email" /></td>
	</tr>
	<tr>
		<td>Player 3:</td>
		<td><input type="text" name="player3" /></td>
		<td>Email: <input type="text" name="player3email" /></td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Create new team" /></td>
	</tr>

</table>


</form>
