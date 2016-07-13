<?php

/**
 * Class myLog just for type definition stupid PHP doesn't have typing
 * @var $properties Properties
 */
class myLog{
	/**
	 * @var $namespace string
	 */
	public $namespace;
	/**
	 * @var $entity string
	 */
	public $entity;
	/**
	 * @var $kind string
	 */
	public $kind;
	/**
	 * @var $properties Properties
	 */
	public $properties;
}

/**
 * Class Properties just for type definition, I want auto completion on my object too
 */
class Properties{
	public $type;
	public $done;
	public $created;
	public $description;
}
class Log {
	public function index(){
		if($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT'){
			$this->post();
		}elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
			$this->get();
		}
	}

	/**
	 * @return myLog
	 */
	private function _getLog(){
		return json_decode(file_get_contents('php://input'));
	}
	private function post(){
		$json = $this->_getLog();
		$obj = new GDS\Schema('Log');
		$obj->addString('namespace')
			->addString('entity')
			->addString('kind')
			->addString('type')
			->addBoolean('done')
			->addDatetime('created')
			->addString('Description');
		$log = new GDS\Store($obj);
		$object = $log->createEntity([
			'namespace' => '',
			'entity' => '',
			'kind' => '',
			'type' => '',
			'done' => '',
			'created' => '',
			'Description' => ''
		]);
		var_dump($object);
	}
	private function get(){

	}
}