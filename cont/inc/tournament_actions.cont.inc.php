<?php

switch ($tournament->get_status()) {
	case 0:
		$startstop = '
			<span class="grey1">registration still open</span>
		';

		$registration = '
			<a href="/greifmasters/index.php?cat=tournament&amp;p1='.$tournament->get_id().'&amp;p2=1">close registration</a>
		';
	break;

	case 1:
		$startstop = '
			<a href="/greifmasters/index.php?cat=tournament&amp;p1='.$tournament->get_id().'&amp;p2=2">start tournament</a>
		';

		$registration = '
			<a href="/greifmasters/index.php?cat=tournament&amp;p1='.$tournament->get_id().'&amp;p2=0">re-open registration</a>
		';
	break;


	case 2:
		$startstop = '
			<a href="/greifmasters/index.php?cat=tournament&amp;p1='.$tournament->get_id().'&amp;p2=3">end tournament</a><br />
			<a href="/greifmasters/index.php?cat=play_tournament&amp;p2='.$tournament->get_id().'">PLAY THIS TOURNAMENT!!</a><br />
			<a href="/greifmasters/index.php?cat=tournament&amp;p2='.$tournament->get_id().'/reset">reset tournament</a>
		';

		$registration = ' ';

	break;

	case 3:
		$startstop = '
			<a href="/greifmasters/index.php?cat=tournament&amp;p2='.$tournament->get_id().'/reset">reset tournament</a>
		';

		$registration = ' ';


	break;

}


echo "\n".'
	<table>
		<tr>
			<th colspan="2">Actions</th>
		</tr>
		<tr>
			<td>'.$startstop.'</td>
			<td><a href="/greifmasters/index.php?cat=tournament&amp;p2='.$tournament->get_id().'&amp;p3=edit">edit tournament information</a></td>
		</tr>
		<tr>
			<td>'.$registration.'</td>
			<td><a href="/greifmasters/index.php?cat=tournament&amp;p2='.$tournament->get_id().'/massmail">send newsletter to teams</a></td>
		</tr>
	</table>
'."\n";


?>
