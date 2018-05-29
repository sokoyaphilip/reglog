<?php

class Actions {
	private $_db,
			$_data;
	/***
		Nothing serious here... Just some famzy...
	***/
	public function __construct( $media){	
		$this->_db = DB::getInstance();	
		if($media){			
			$this->find('files', 'media_name', $media);
		}
	}


	public function find($table, $field, $source = null ){
		if( $source ){
			$data = $this->_db->get($table, array($field, '=', $source));
			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}


	public function update_media($table, $fields = array(), $id){

		if(!$this->_db->update( $table, $id, $fields )){
			throw new Exception('There was an error updating');
		}
	}

	public function exists() {
		return(!empty($this->_data)) ? true : false ;
	}

	public function data(){
		return $this->_data;
	}
}