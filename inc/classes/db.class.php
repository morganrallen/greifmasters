<?php
require_once "config.php";

#@todo: free result and other performance stuff still to be implemented

class db extends mysqli {
	protected $table;

	function __construct($table) {
		global $config;
		parent::__construct($config["db"]["host"], $config["db"]["username"], $config["db"]["password"], $config["db"]["db"]);
		 
		if (mysqli_connect_errno()) {
		  printf(
			"Can't connect to MySQL Server. Errorcode: %s\n",
			mysqli_connect_error()
		  );
		 
		  exit;
		}

		$columns = self::fetch_results("SHOW COLUMNS FROM " . $table);
		foreach($columns as $col)
			$this->{$col["Field"]} = "";
		$this->table = $table;
	}
	
	public function list_entries($where_clause=''){
		$list = self::select('*');
		return $list;
	}
	
	protected function store($columns, $arguments) {
		$query = '
			INSERT INTO ' . $this->table . ' (' . $columns . ')
			VALUES (' . $arguments . ')
		';

		self::query ( $query );
			
		self::load_entry($this->insert_id);
	
		#@todo: success-notificatin through session variable or something. important database operations should give feedback
	}

	public function load_entry($id){
		$result = self::select('*', "id='$id'");
		$load = $result[0];
		
		while ( list ( $key, $value ) = each ( $load ) ) {
			$this->$key = $value ;
		}
	}

	public function delete($id) {
		$query = "DELETE FROM $this->table WHERE id='" . $id ."'";
		self::query ( $query );
	}

	public function select($columns, $where_clause = '') {
		$query = 'SELECT ' . $columns . ' FROM ' . $this->table; 
		if ($where_clause != '') {
			$query .= ' WHERE ' . $where_clause;
		}

		return self::fetch_results($query);
	}
	
	
	protected function update($arguments, $where_clause){
		$query = 'UPDATE '. $this->table . ' SET ' . $arguments . ' WHERE ' . $where_clause;
		self::query ( $query );
		
		self::load_entry($this->id);
	}
	
	public function fetch_results($query){
		$result = self::query ( $query );

		if ($this->affected_rows == 0) {
			return FALSE;
		}
		
		$return = array();
		
		while ($row = $result->fetch_assoc()){
	        $return[] = $row;
	    }
	    
	    $result->close ();

	    return $return;
	}
	
	public function query($query) {
		try {
			$result = parent::query ( $query );
		} catch ( Exception $exception ) {
				echo 'Error: ' . $exception->getMessage () . '<br />';
				echo 'File: ' . $exception->getFile () . '<br />';
				echo 'Line: ' . $exception->getLine () . '<br />';
		}
		
		if (mysqli_error ( $this )) {
			throw new exception ( mysqli_error ( $this ), mysqli_errno ( $this ) );
		}
		return $result;
	}
	
	public function exists($query){
		$result = self::query("SELECT id FROM $this->table WHERE $query");
		if ($this->affected_rows == 0) {
			return FALSE;
		}
		return TRUE;
		
	}
}

?>
