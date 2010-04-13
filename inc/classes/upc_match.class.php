<?php


class upc_match extends match {
	
	
	protected $id;
	protected $match_id;
	protected $order;
	protected $ready_team1;
	protected $ready_team2;

#@todo: class is just scratch
	public function __construct() {

		parent::__construct ('upc_matches');
	
	}
	
	
	public function store($match_id){
		db::store('match_id', $match_id);
	}
	
	public function finish($id){
		
		
		$upc_id = self::select('id',"match_id='$id'");
		$this->id = $upc_id[0]['id'];
		
		self::load_entry($this->id);
		
		$match = new match();
		$match->load_entry($this->match_id);
		$match->set_status(1);
		
		self::delete($this->id);
		
		
	}
	
}

?>