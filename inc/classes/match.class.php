<?php


class match extends db {

	
	protected $id;
	protected $bracket_id;
	protected $team1;
	protected $team2;
	protected $datetime;
	protected $identifier;


	public function __construct($table = 'matches') {

		parent::__construct ($table);
	
	}

	
	public function get_id(){
		return $this->id;
	}
	
	public function get_bracket_id(){
		return $this->bracket_id;
	}
	
	public function get_team1(){
		return $this->team1;
	}
	
	public function get_team2(){
		return $this->team2;
	}
	
	public function get_goals_1(){
		$goals = new goal();
		return $goals->get_match_goals($this->id, self::get_team1());
	}
	
	public function get_goals_2(){
		$goals = new goal();
		return $goals->get_match_goals($this->id, self::get_team2());
	}	
	
	public function get_datetime(){
		return $this->datetime;
	}
	
	public function get_identifier(){
		return $this->identifier;
	}
	
	#@todo: set-methods complete?
	
	
	public function set_status($status){
		
		parent::update("status='$status'", "id='$this->id'");
	}
	
	public function set_datetime(){
		parent::update("datetime=NOW()", "id='$this->id'");
	}
	
	public function store($match){
		
		parent::store('bracket_id, team1, team2, identifier', $match);
		
	}
	
	public function delete_match(){
		
		parent::query("
			DELETE FROM
				upc_matches
			WHERE
				match_id='$this->id'
		");
		
		parent::query("
			DELETE FROM
				goals
			WHERE
				match_id = '$this->id'
		");
		
		parent::query("
			DELETE FROM
				fouls
			WHERE
				match_id = '$this->id'
		");
		
		parent::delete($this->id);
		
	}
}

?>