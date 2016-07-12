<?php

class Router
{
	private $request_url;
	public function __construct($request_url = null)
	{
		$this->request_url = explode('?',$request_url)[0];
	}
	public function getController(){
		$request = explode('/', $this->request_url);
		if(count($request) === 1 or $this->request_url === '/'){
			return 'Welcome';
		}
		return ucfirst(explode('/', $this->request_url)[1]);
	}
	public function getMethod(){
		if($this->request_url === '/')
			return 'index';
		$request = explode('/',$this->request_url);
		return array_key_exists(2, $request)&&$request[2]!=''?$request[2]:'index';
	}

	public function setRequestUrl($request_url)
	{
		$this->request_url = explode('?',$request_url)[0];

		return $this;
	}
}