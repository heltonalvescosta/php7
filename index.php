<?php 
session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Modal\User;
use \Hcode\Modal\Product;
use \Hcode\motal\Category;

$app = new Slim();

$app->config('debug', true);

require_once("function.php");
require_once("site.php");
require_once("admin.php");
require_once("admin-users.php");
require_once("admin-categories.php");




$app->run();

 ?>