<?php


#@todo: completely unfinished class. just scratch

class single_elimination extends bracket{

	
	
	public function draw_bracket($array){
		
		$size = sizeof($array);
		if ($size - pow(2, floor(log($size, 2))) != 0){return ('Unvalid number of teams chosen to be seeded in the single elimination bracket');}

		
		$chunked = array_chunk($array, sizeof($array)/2);
		$first = $chunked[0];
		$second = array_reverse($chunked[1]);
		
		$matches = array();
		
		while (sizeof ($first) > 0){
			$matches[] = array (array_shift($first), array_shift($second));
		}
		
		if (sizeof($matches) < 2){
			array_push($matches, '1.1');
			parent::store_matchlist($matches);
			return;
			
		}
		
		
		$chunked = array_chunk($matches, sizeof($matches)/2);
		$first = $chunked[0];
		$second = array_reverse($chunked[1]);
		
		$matchlist = array();
		$number_of_matches = $size/2;
		
		$i = 1;
		
		while (sizeof ($first) > 0){
			
			$match1 = array_shift($first);
			$match2 = array_shift($second);
			
			
			array_push($match1, $number_of_matches.'.'.$i);
			$i++;
			
			array_push($match2, $number_of_matches.'.'.$i);
			$i++;
			
			$matchlist[] = $match1;
			$matchlist[] = $match2;
			
			
			$first = array_reverse($first);
			$second = array_reverse($second);

		}
		
		$remaining = $number_of_matches/2;
		
		while ($remaining >= 1){
			for ($i=1; $i<=$remaining; $i++){
				$matchlist[] = array(-1, -1, $remaining.'.'.$i);
			}
			$remaining = $remaining/2;
		}
		
		parent::store_matchlist($matchlist);	

	}
	
	
	public function get_ranking(){
		
		$query = "
			SELECT
				m.identifier,
				m.team1 AS team1_id,
				m.team2 AS team2_id,
				IF(m.team1 <> 0, t1.name, 'tba') AS team1,
				IF(m.team2 <> 0, t2.name, 'tba') AS team2
			FROM
				matches AS m
			LEFT JOIN teams AS t1 ON t1.id = m.team1
			LEFT JOIN teams AS t2 ON t2.id = m.team2
			WHERE
				bracket_id = '$this->id'
		";

		
		$results = db::fetch_results($query);
		
		return $results;

	}
	
	
	public function draw_ranklist(){
		
		$results = self::get_ranking();
		
		echo '
			<table class="ranking">
				<tr><th>no.</th><th>Team 1</th><th>Team 2</th><th>identifier</th></tr>
		';
		$i = 1;
		foreach ($results as $match){
			echo '<tr><td>'.$i.'.)</td><td>'.$match['team1'].'</td><td>'.$match['team2'].'</td><td>'.$match['identifier'].'</td></tr>';
			$i++;
		}
		
		echo '</table>';
	}
	
}



?>
