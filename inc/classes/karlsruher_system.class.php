<?php



class karlsruher_system extends bracket {

	
	protected $calculated_time;
	protected $mode = 1;
	#@todo: "mode" deprecated?
	protected $number_of_matches;
	
#@todo: bunch of variables missing


	public function __construct() {

		parent::__construct();
		
	}

	public function store($bracket_name, $timelimit_policy=''){
		
		$this->bracket_name = $bracket_name;
		$this->type = 'karlsruher_system';
		
		$this->timelimit5 = $timelimit_policy[0][0];
		$this->pause5 = $timelimit_policy[0][1];
		$this->timelimit4 = $timelimit_policy[1][0];
		$this->pause4 = $timelimit_policy[1][1];
		$this->timelimit3 = $timelimit_policy[2][0];
		$this->pause3 = $timelimit_policy[2][1];
		$this->timelimit2 = $timelimit_policy[3][0];
		$this->pause2 = $timelimit_policy[3][1];
		$this->timelimit1 = $timelimit_policy[4][0];
		$this->pause1 = $timelimit_policy[4][1];
		
		parent::store();
		
		
	}
	
	
	

	
	
	public function seeding_step1(){
		$registration = new registration();
		$teams = $registration->get_registered_teams($_SESSION['tournament_id']);
		$db = new db('seeding');
		
		foreach ($teams as $team){
			$db->query("INSERT INTO seeding (team_id, bracket_id) VALUES ('".$team['id']."', '$this->id')");
		}
	}
	
	public function get_seeding(){
		$db = new db('seeding');
		return $db->fetch_results("SELECT * FROM seeding ORDER BY value");
		#@todo: WHERE bracket_id='$this->id'
	}
	
	
	public function get_calculated_time($format){
		parent::get_calculated_time($format);
	}
	
	public function calculate_time(){
		
		#@todo: for elimination style brackets this calculation has to take into consideration that timelimits can differ.
		return self::get_number_of_matches()*($this->match_duration+$this->pause);
	}
	
	public function get_number_of_matches(){
		
		return parent::get_number_of_teams()*$this->offset;
		
	}
	
	
	public function draw_bracket($bracket_id, $offset, $shuffle = FALSE){
		
		
		
		$matchlist = array();
		$number_of_teams = parent::get_number_of_teams();
		
		$seeding = self::get_seeding();
		#@todo: seeding table is never emptied and results are not selected by bracket only as it should be (see above) 
		
		
		foreach ($seeding as $row){
			$team = new team();
			for ($i=1; $i<=$offset; $i++){

			#@todo: check if the -1 as identifier affects the shuffle-function (called below). was only tested with arrays like (team1, team2). the third index will most probably cause false results.
				
				if ($row['id']+$i <= $number_of_teams){
					$opponent = $row['id']+$i;
					$matchlist[]=array($seeding[$row['id']-1]['id'], $seeding[$opponent-1]['id'], -1);
				}
				
				if($row['id'] - $i < 0){
					$opponent = $row['id'] + $number_of_teams - $i;
					$matchlist[]=array($seeding[$row['id']-1]['id'], $seeding[$opponent-1]['id'], -1);
				}
				
			}
		}

		


		
		$matchlist = shuffle_matchlist($matchlist,$number_of_teams);
	#@todo: seperate the shuffle function, or add a possibility to skip that step

		
		
		parent::store_matchlist($matchlist);
	}
	
	

	public function get_ranking($limit = '', $ranking_only = FALSE){
		
		
		#FIXME: query is complete crap and just hacked together
		
		$query = "

		SELECT
		t.name AS team,
		t.id AS team_id,
		t.city AS city,
		p1.name AS player1,
		p2.name AS player2,
		p3.name AS player3,

				
		(
			SELECT
				count(*)
			FROM
				matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(
					SELECT
						count(*)
					FROM
						goals
					WHERE(
						((team_id = t.id AND regular = '1')
						OR
						(team_id != t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				) > (
					SELECT
						count(*)
					FROM
						goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$this->id."'
		) AS matches_won,
		
		
		
		
				(
			(SELECT
				count(*) * 3
			FROM
				matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(
					SELECT
						count(*)
					FROM
						goals
					WHERE(
						((team_id = t.id AND regular = '1')
						OR
						(team_id != t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				) > (
					SELECT
						count(*)
					FROM
						goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$this->id."'
		) +
		
		
						(
			SELECT
				count(*)
			FROM
				matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(SELECT count(*) FROM goals WHERE team_id = t.id AND match_id = m.id) = (SELECT count(*) FROM goals WHERE team_id != t.id AND match_id = m.id)
			AND
				bracket_id = '".$this->id."'
		)
		
		
		
		) AS points,
		
		
		
		
		
		(
			SELECT
				count(*)
			FROM
				matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(
					SELECT
						count(*)
					FROM
						goals
					WHERE(
						((team_id = t.id AND regular = '1')
						OR
						(team_id != t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				) < (
					SELECT
						count(*)
					FROM
						goals
					WHERE(
						((team_id != t.id AND regular = '1')
						OR
						(team_id = t.id AND regular = '0'))
						AND
						match_id = m.id
						)
				)
							
			AND
				bracket_id = '".$this->id."'
		) AS matches_lost,
		
		
		
		
		
		
				(
			SELECT
				count(*)
			FROM
				matches AS m
			WHERE
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				(SELECT count(*) FROM goals WHERE team_id = t.id AND match_id = m.id) = (SELECT count(*) FROM goals WHERE team_id != t.id AND match_id = m.id)
			AND
				bracket_id = '".$this->id."'
		) AS matches_draw,
		
		
		
		
		
		
		(
			SELECT
				count(*)
			FROM
				goals
			WHERE
				((team_id = t.id AND regular = '1')
				OR
				(team_id != t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
		) AS goals,
		
		
		
		
		(
			(SELECT
				count(*)
			FROM
				goals
			WHERE
				((team_id = t.id AND regular = '1')
				OR
				(team_id != t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
			) -
			(
			SELECT
				COUNT(*)
			FROM
				goals 
			WHERE
				((team_id != t.id AND regular = '1')
				OR
				(team_id = t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
		)
		) AS goal_difference,
		
		
		
		
		(
			SELECT
				COUNT(*)
			FROM
				goals 
			WHERE
				((team_id != t.id AND regular = '1')
				OR
				(team_id = t.id AND regular = '0'))
			AND
				match_id IN (SELECT id FROM matches WHERE (team1=t.id OR team2=t.id) AND bracket_id = '".$this->id."' AND status ='1')
		) AS goals_against,
		
		
		
		
		
		
		(
			SELECT
				COUNT(*)
			FROM
				matches
			WHERE
				status >= '1'
			AND
				(team1 = t.id
				OR
				team2 = t.id)
			AND
				status ='1'
			AND
				bracket_id = '".$this->id."'
		) AS games_played
		
		
		
		FROM
			teams AS t
		INNER JOIN players AS p1 ON t.player1 = p1.id
		INNER JOIN players AS p2 ON t.player2 = p2.id
		INNER JOIN players AS p3 ON t.player3 = p3.id
		WHERE
			t.id IN (
				SELECT
					team1
				FROM
					matches
				WHERE
					bracket_id='".$this->id."'
			)
		OR
			t.id IN (
				SELECT
					team2
				FROM
					matches
				WHERE
					bracket_id='".$this->id."'
			)
	";
		
	
	
	$query .= "
		ORDER BY points DESC, matches_won DESC, matches_lost ASC, goal_difference DESC
	";
	
	if (is_numeric($limit)){$query .= "LIMIT ".$limit." \n";}
	
	
	$results = parent::fetch_results($query);
	
	if ($ranking_only == TRUE){
		foreach ($results as $index => $result){
			$results[$index] = $result['team_id'];
		}
	}
	
	
	return $results;

	}
	
	
	public function draw_ranklist(){
		
		$results = self::get_ranking();
		
		echo '
			<table class="ranking">'."\n".'
				<tr><th>Rank</th><th>Team name</th><th>Points</th><th>won</th><th>lost</th><th>draw</th><th>goal difference</th><th>goals</th><th>goals against</th><th>games played</th></tr>'."\n".'
		';
		$i = 1;
		foreach ($results as $team){
			echo '
				<tr>
					<td>'.$i.'.)</td>
					<td title="'.$team['player1'].', '.$team['player2'].', '.$team['player3'].' ('.$team['city'].')">'.$team['team'].'</td>
					<td>'.$team['points'].'</td>
					<td>'.$team['matches_won'].'</td>
					<td>'.$team['matches_lost'].'</td>
					<td>'.$team['matches_draw'].'</td>
					<td>'.$team['goal_difference'].'</td>
					<td>'.$team['goals'].'</td>
					<td>'.$team['goals_against'].'</td>
					<td>'.$team['games_played'].'</td>
				</tr>
			';
			$i++;
		}
		
		echo '</table>';
	}
	
	
}

?>