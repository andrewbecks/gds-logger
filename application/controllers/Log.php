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
	 * @var $schema string
	 */
	public $schema;
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
		$schema = $json->schema;
		$namespace = $json->namespace;
		$entity = $json->entity;
		$kind = $json->kind;
		$type = $json->properties->type;
		$done = $json->properties->done;
		$created = $json->properties->created;
		$description = $json->properties->description;
		$obj = new GDS\Schema($schema);
		$obj->addString('namespace')
			->addString('entity')
			->addString('kind')
			->addString('type')
			->addBoolean('done')
			->addDatetime('created')
			->addString('Description');
		$log = new GDS\Store($obj);
		$object = $log->createEntity([
			'namespace' => $namespace,
			'entity' => $entity,
			'kind' => $kind,
			'type' => $type,
			'done' => $done,
			'created' => new DateTime($created),
			'Description' => $description
		]);
		var_dump($object);
	}
	private function get(){

	}
}