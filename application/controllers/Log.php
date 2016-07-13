<?php

/**
 * Class myLog just for type definition stupid PHP doesn't have typing
 * @var $properties Properties
 */
class myLog{
	public $_id;
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
	/**
	 * @var $schema \GDS\Schema
	 */
	private $schema;
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
	private function _makeSchema($schema){
		$obj = new GDS\Schema($schema);
		$obj->addString('namespace')
			->addString('entity')
			->addString('kind')
			->addString('type')
			->addBoolean('done')
			->addDatetime('created')
			->addString('Description');
		$this->schema=$obj;
	}
	private function post(){
		$json = $this->_getLog();
		$schema = $json->schema;
		$this->_makeSchema($schema);
		$namespace = $json->namespace;
		$entity = $json->entity;
		$kind = $json->kind;
		$type = $json->properties->type;
		$done = $json->properties->done;
		$created = $json->properties->created;
		$description = $json->properties->description;
		$obj = $this->schema;
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
		$log->upsert($object);
		$json->_id=$object->getKeyId();
		header('Content-Type:application/json');
		set_status_header(201);
		echo json_encode($json, JSON_PRETTY_PRINT);
	}
	private function get(){
		try{

			$this->_makeSchema(array_key_exists('schema',$_GET)?$_GET['schema']:'log');
			$store = new GDS\Store($this->schema);
			$rows = $store->fetchAll((array_key_exists('query',$_GET)?$_GET['query']:null));
			$data=[];
			foreach($rows as $row){
				$temp=$row->getData();
				$temp['_id']=$row->getKeyId();
				$data[]=$temp;
			}
			header('Content-Type:application/json');
			echo json_encode($data,JSON_PRETTY_PRINT);
		}catch(Exception $e){
			echo $e->getMessage();
			set_status_header(500);
			echo "\nSome weird Exception";
		}
	}
}