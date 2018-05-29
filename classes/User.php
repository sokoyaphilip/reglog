<?php

class User {
	private $_db,
			$_data,
			$_sessionName,
			$_cookieName,
			$_isLoggedIn;

	public function __construct($user = null ){
		$this->_db = DB::getInstance();
		$this->_sessionName = Config::get('session/session_name');
		$this->_cookieName = Config::get('remember/cookie');

		if(!$user){
			if(Session::exists($this->_sessionName)){
				$user = Session::get($this->_sessionName);

				if($this->find('users',$user)){
					$this->_isLoggedIn = true;
				}else{
					//process logout
				}
			}
		}else {
			$this->find('users', $user);
		}
	}

	public function create( $table, $fields = array()) {
		if(!$this->_db->insert( $table, $fields) ) {
			throw new Exception('There was a problem creating the row.');
		} 
	}

	public function find($table, $source = null ){
		if( $source ){
			$field = (is_numeric($source)) ? 'id': 'email';
			$data = $this->_db->get($table, array($field, '=', $source));

			if($data->count()){
				$this->_data = $data->first();
				return true;
			}
		}
		return false;
	}

	public function update($table, $fields = array(), $id = null){
		
		if( !$id && $this->isLoggedIn()) {

			$id = $this->_db->data()->id;
		}

		if(!$this->_db->update( $table, $id, $fields )){
			throw new Exception('There was an error updating');
		}
	}

	public function update_media($table, $fields = array(), $id){

		if(!$this->_db->update_media( $table, $id, $fields )){
			throw new Exception('There was an error updating.');
		}
	}

	public function login( $email = null , $password = null, $remember = false ){		
		
		if(!$email && !$password && $this->exists()){
			//login the user
			Session::put($this->_sessionName, $this->data()->id);

		}else{
			$user = $this->find('users',$email);
			if($user){
				if($this->data()->password === Hash::make($password, $this->data()->salt)){
					//set a session
					Session::put($this->_sessionName, $this->data()->id); 

					if($remember) {
						$hash = Hash::unique();
						$hashCheck = $this->_db->get('user_session', array('user_id', '=', $this->data()->id));

						if(!$hashCheck->count()) {
							$this->_db->insert('user_session',array(

								'user_id' => $this->data()->id,
								'hash'	=> $hash
							));
						}else {
							$hash = $hashCheck->first()->hash;
						}

						Cookie::put($this->_cookieName, $hash,Config::get('remember/cookie_expire'));
					}
					return true;
				}
			}
		}
		return false;
	}

	public function hasPermission( $key ){
		$group = $this->_db->get('groups', array('id', '=', $this->data()->groups));
		
		if($group->count()){
			$permission = json_decode($group->first()->permissions,true);
			if($permission[$key] == true ){
				return true;
			}

			return false;
		}
	}

	public function exists() {
		return(!empty($this->_data)) ? true : false ;
	}

	public function logout(){

		$this->_db->delete('user_session',array('user_id', '=', $this->data()->id));
		Session::delete($this->_sessionName);
		Cookie::delete($this->_cookieName);
	}

	public function data(){
		return $this->_data;
	}

	public function isLoggedIn(){
		return $this->_isLoggedIn;
	}
}