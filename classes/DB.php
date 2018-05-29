<?php

class DB{
	//SINGETON PATTERN : Get an instance of database
	private static $_instance = null; // store instance of DB connection
	private $_pdo, //use to instantiate the pdo object
			$_query, 
			$_error = false, //return bool of error
			$_results, //store results
			$_counts = 0; //store the number of rows

	//connect to the DB; this will run when the class is instantiated
	private function __construct() { //set to private; $_instance will take the work
		try {
			$this->_pdo = new PDO('mysql:host=' .Config::get("mysql/host"). ';dbname=' .Config::get("mysql/db"), Config::get("mysql/username"), Config::get("mysql/password"));
			
		} catch (PDOException $e) {
			//kill the app
			die($e->getMessage());
		}
	}

	//establish one instance connection
	public static function getInstance(){
		//check if we have already instantiated the db
		if( !isset(self::$_instance) ){
			self::$_instance = new DB();
		}
		return self::$_instance;
	}

	public function query( $sql , $params = array()) {
		//reset error to false
		$this->_error = false;
		//prepare query
		if( $this->_query = $this->_pdo->prepare($sql) ){
			//check if we are to bind
			$x = 1; //first value of the params
			if( count($params) ) {
				foreach ($params as $param ) {
					$this->_query->bindValue( $x , $param);
					$x++;
				}
			}
			// die( $sql );
			if( $this->_query->execute() ){
				//store the result
				$this->_results = $this->_query->fetchAll(PDO::FETCH_OBJ);
				//update the count
				$this->_count = $this->_query->rowCount();
			} else {
				$this->_error = true;
			}
		}

		return $this;
	}

	public function action( $action, $table, $where = array() ){
		//field, operator, and value

		if(count( $where ) === 3 ){
			$operators = array('=', '<', '>', '>=', '<=');

			$field 		= $where[0];
			$operator 	= $where[1];
			$value 		= $where[2];
			//is operator insie the array i defined?
			if( in_array($operator , $operators)){
				//$sql = "SELECT * FROM users WHERE username = 'philip'"
				//this cant still check for "SELECT * FROM users WHERE id= 1 OR username = 'philip'"
				//use query methods straightway
				$sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
				//query
				if( !$this->query($sql, array($value))->error() ){

					return $this;
				}
			}	

		}

		return false;

	}


	public function get($table, $where){
		return $this->action('SELECT *', $table, $where);
	}

	public function delete( $table ,  $where) {
		return $this->action('DELETE *', $table, $where);
	}

	public function results(){
		return $this->_results;
	}

	public function first(){
		return $this->results()[0];
	}

	public function insert( $table, $fields = array()){
		if(count($fields)){
			$keys = array_keys( $fields );
			$values = '';
			$x = 1; // pointer

			foreach($fields as $field) {
				$values .= " ? ";
				if( $x < count($fields)){
					$values .= ',';  
				}
				$x++;
			}
			
			//$sql = "INSERT INTO users(username,password,salt,...)";
			$sql = "INSERT INTO {$table} ( `" . implode( '`,`', $keys ). "` ) VALUES ({$values})";
			// die( $sql );
			if( !$this->query( $sql, $fields )->error()){
				return true;
			}
		}
		return false;
	}

	public function update( $table, $id, $fields ){
		$set = '';
		$x = 1;

		foreach($fields as $name => $value ){
			$set .= "{$name} = ?";
			if($x < count($fields)) {
				$set .= ', ';
			}

			$x++;
		}

		$sql = "UPDATE {$table} SET {$set} WHERE id = {$id}";


		if( !$this->query($sql, $fields)->error()){
			return true;
		}

		return false;
	}

	public function update_media( $table, $id, $fields ){
		$set = '';
		$x = 1;

		foreach($fields as $name => $value ){
			$set .= "`{$name}` = '{$value}'";
			if($x < count($fields)) {
				$set .= ', ';
			}
			$x++;
		}
		$sql = "UPDATE {$table} SET {$set} WHERE `media_name` = '{$id}'";

		if( !$this->query($sql)->error()){
			// die('Here' . $sql );
			return true;
		}else{
			// die('Not Here' . $sql );
			return false;			
		}
	}

	public function error(){
		return $this->_error;
	}

	public function count() {
		return $this->_count;
	}

}