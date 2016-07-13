<?php

/**
 * Created by PhpStorm.
 * User: cyberkiller
 * Date: 7/13/16
 * Time: 10:32 PM
 */
class Test {
	public function index(){
		$obj_store = new GDS\Store('test');
		$obj_book = $obj_store->createEntity([
			'title' => 'The Merchant of Venice',
			'author' => 'William Shakespeare',
			'isbn' => '1840224312'
		]);
		$obj_store->upsert($obj_book);
		var_dump($obj_store->fetchOne());
	}
}