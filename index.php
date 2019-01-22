<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php

require_once './sys/autoload.php';
error_reporting(1);

Session::begin();

$request = Http::getRequestedPath();

$routes = require_once './routes.php';
$args = $foundRoute = null;

//otkrivanje rute
foreach ($routes as $route) {
    
    if ($route->isMatched($request, $args)) {
        $foundRoute = $route;
        break;
    }
}

$controller = './app/controllers/' . $foundRoute->getController() . 'Controller.php';

if(!file_exists($controller)){
    
    //ob_clean();
    die('CONTROLLER: File not found.');
}
require_once $controller;

//postavljanje regulatora
$className = $foundRoute->getController() . 'Controller';
$worker = new $className;

//pozivanje predmetode
if(method_exists($worker, '__pre')){
    call_user_func([$worker, '__pre']);
}

//pozivanje odgovarajuće metode kontrolera
if(!method_exists($worker, $foundRoute->getMethod())){
    //ob_clean();
    echo 'Matere ti -  ' . $foundRoute->getController() .'<br>';
    echo 'Matere ti -  ' . $foundRoute->getMethod() .'<br>';
    die('CONTROLLER: Method not found');
}

$methodName = $foundRoute->getMethod();
call_user_func([$worker, $methodName], $args);

//pozivanje __post metode
if(method_exists($worker, '__post')){
    call_user_func($worker, '__post');
}

//preuzimanje globalnih podataka
$DATA = $worker->getData();

//put do predloška
$headerView = './app/views/_global/header.php';
$footerView = './app/views/_global/footer.php';
$view = './app/views/' . $foundRoute->getController() . '/' . $foundRoute->getMethod() . '.php';

//Učitavanje zaglavlja
if(!file_exists($headerView)){
    ob_clean();
    die('VIEW: Header file not found.');
}

//Učitavanje predloška glavnog zaslona
if(!file_exists($view)){
    ob_clean();
    die('VIEW: Main template file not found.');
}

//Učitavanje letaka
if(!file_exists($footerView)){
    ob_clean();
    die('VIEW: Footer file not found');
}

//dodatni javascript modul
$jsModelu = 'assets/js/modules/' . sprintf('%s_%s.js', $foundRoute->getController(), $foundRoute->getMethod());
if (file_exists($jsModule)) {
	$DATA['JAVASCRIPT_MODULE'] = $jsModule;
}

require_once $headerView;
require_once $view;
require_once $footerView;






    

?>