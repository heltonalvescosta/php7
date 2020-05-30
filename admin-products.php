<?php

use \Hcode\PageAdmin;
use \Hcode\Modal\User;
use \Hcode\Modal\Product;


$app->get("/admin/products", function(){

		User::ferifyLogin();
		
		$products = Product::listAll();
		
		$page = new PageAdmin();
		  
		$page->setTpl("products", [
			"products"=>$products
		]);
		
		
		
});

$app->get("/admin/products-create", function(){

		User::ferifyLogin();
		
		$page = new PageAdmin();
		
		$page->setTpl("products-create");
		
});

$app->pos("admin/products/create", function(){
	
		User::ferifyLogin();
		
		$product =  new Product();
		
		$product->setData($_POST);
		
		$product->save();
		
		header("Location: /admin/products");
		
});

$app->get("/admin/products/:idproduct", function(:idproduct){

		User::ferifyLogin();
		
		$product =  new Product();
		
		$product->get((int)$idproduct);

		$page = new PageAdmin();
		
		$page->setTpl("products-update", [
			'product'=>$product->getValue()
		]);
		
});

$app->pos("/admin/products/:idproduct", function(:idproduct){

		User::ferifyLogin();
		
		$product =  new Product();
		
		$product->get((int)$idproduct);

		$product->setData($_POST);

		$product->save();

		$product->setPhoto($_FILES['file']);

		header('Location: /admin/products');
		exit;	
});

$app->get("/admin/products/:idproduct/delete", function(:idproduct){

		User::ferifyLogin();
		
		$product =  new Product();
		
		$product->get((int)$idproduct);

		$product->delete();
				
		header('Location: /admin/products');
		exit;	
});




?>