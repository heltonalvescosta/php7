<?php

use \Hcode\Page;
use \Hcode\Model\Product;


$app->get("/", function() {
	
    $products = Product::listAll();
    
	$page->setTpl("index", [
		'products'=>product::checkList($products)
		]);
});








?>