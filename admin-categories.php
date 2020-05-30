<?php

use \Hcode\PageAdmin;
use \Hcode\Modal\User;
use \Hcode\motal\Category;



$app->get("/admin/categories", function(){

		$categories = Category::listAll();
		
		$page = new PageAdmin();
		
		$page->setTpl("categories", [
			"categories"=>$categories
			]);
});

$app->get("/admin/categories/create", function(){
		
		$page = new PageAdmin();
		
		$page->setTpl("categories-create");
});

$app->post("/admin/categories/create", function(){
		
		$category = new Category();
		
		$page->setData($_POST);
		
		$category->save();
		header('Location: /admin/categories');
		exit;
});

$app->get("/admin/categories/:idcategory/delete", function($idcategory){;
	
		$category = new Category();
		
		$category->get((int)$idcategory);
		
		$category->delete();
		
		header('Location: /admin/categories');
		exit;
		
});

$app->post("/admin/categories/:idcategory", function($idcategory){

		User::verifyLogin();
		
		$category = new Category();
		
		$category->get((int)$idcategory);
		
		$category->setData($_POST);
		
		$category->save();
		
		header('Location: /admin/categories');
		exit;
	
});

$app->get("/admin/categories/:idcategory", function($idcategory){

		User::verifyLogin();
		
		$category = new Category();
		
		$category->get((int)$idcategory);
		
		$page = new PageAdmin();
		
		$page->setTpl("category-update", [
			'category'=>getValues()		
		]);
	
});






?>