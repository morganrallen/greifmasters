<form action="<?php echo BASE?>/play_tournament/brackets/new/" method="post">
<input type="hidden" name="nextstep" value="1" />
<table>
	<tr>
		<td>Name of bracket:</td>
		<td><input type="text" name="bracket_name" /></td>
	</tr>
	<tr>
		<td>type:</td>
		<td>
			<select name="type">
			<option></option>
			<?php 
				$db = new db('bracket_types');
				$types = $db->select("*");
				
				foreach ($types as $row){
					echo '<option value="'.$row['class_name'].'">'.$row['name'].'</option>';	
				}
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" value="Submit" /></td>
	</tr>


</table>


</form>