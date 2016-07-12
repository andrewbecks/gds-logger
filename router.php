<?php
require_once __DIR__.'/Router.php';
$router = new Router($_SERVER['REQUEST_URI']);
$controller = $router->getController();
$method = $router->getMethod();
$file = __DIR__.'/application/controllers/'.$controller.'.php';
if(!file_exists($file)){
	set_status_header(404);
	echo '404';
	die();
}
require_once $file;
$instance = new $controller();
if(!method_exists($instance, $method)){
	set_status_header(404);
	echo '404';
	die();
}
$instance->$method();