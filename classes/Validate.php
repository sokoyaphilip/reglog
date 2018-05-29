<?php
class Validate{
	//instantiate db
	private $_passed = false,
			$_errors = array(),
			$_db = null;

	public function __construct(){
		$this->_db = DB::getInstance();
	}

	public function check($source, $items = array()){
		//list through the items
		foreach( $items  as $item => $rules ){
			foreach( $rules as $rule => $rule_value ){
				
				$value = trim($source[$item]);
				$item = escape($item);
				//echo "{$item} {$rule} must be {$rule_value} <br/>";

				if($rule === 'required' && empty($value)){

					$this->addError("{$item} field is empty");
				}else if(!empty($value)){
					switch ($rule) {
						case 'min':
							if(strlen($value) < $rule_value){
								$this->addError("- " .ucfirst(preg_replace('/_/', ' ', $item)) . " Must Be A Minimum of {$rule_value}");
							}
						break;
						case 'max':
							if(strlen($value) > $rule_value){
								$this->addError("- " .ucfirst(preg_replace('/_/', ' ', $item)) ." Must Be A Minimum of {$rule_value}");
							}
						break;
						case 'matches':
							if($value != $source[$rule_value]){
								 $this->addError('- '. ucfirst($rule_value) . " Must be the same with " . ucfirst(preg_replace('/_/', ' ', $item)));
							}
						break;
						case 'unique':
							$check = $this->_db->get($rule_value, array($item, '=', $value));
							if($check->count()){
								//it exists
								$this->addError("- " .ucfirst($item)." aready exists");
							}
						break;
						
						default:
							# code...
							break;
					}
				}
			}
		}

		if( empty($this->_errors) ){
			$this->_passed = true;
		}
		return $this;
	}


	private function addError( $error ){
		$this->_errors[]= $error;
	}

	public function errors(){
		return $this->_errors;
	}

	public function passed(){
		return $this->_passed;
	}

}