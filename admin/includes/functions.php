<?php 

//Deprecated function
// function __autoload($class){

// $class = strtolower($class);

// $path = "includes/{$class}.php";

// if(file_exists($path)){

// 	require_once($path);
// }else{

// 	die("The file name {$class}.php can not be found man..... Too Bad :)");
// }

//}

 function classAutoLoader($class){

 $class = strtolower($class);

 $path = "includes/{$class}.php";

 if(is_file($path) && !class_exists($class)){

 	include $path;

 }else{

 	die("The file name {$class}.php can not be found man..... Too Bad :)");
 }

}

spl_autoload_register('classAutoLoader');

//redirect

function redirect($location){

	header("Location: {$location}");
}


?>