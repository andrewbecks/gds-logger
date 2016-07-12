<?php

class Log {
	public function index(){
		if($_SERVER['REQUEST_METHOD'] === 'POST' || $_SERVER['REQUEST_METHOD'] === 'PUT'){
			$this->post();
		}elseif($_SERVER['REQUEST_METHOD'] === 'GET'){
			$this->get();
		}
	}
	private function post(){
		$obj = new GDS\Schema('Log');
		$obj->addString('namespace')
			->addString('entity')
			->addString('kind')
			->addString('type')
			->addBoolean('done')
			->addDatetime('created')
			->addString('Description');
	}
	private function get(){

	}
}