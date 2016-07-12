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

	}
	private function get(){

	}
}