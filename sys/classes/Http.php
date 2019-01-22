<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

final class Http{
    
    final public static function  isGet(){
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        $method = strtoupper($method);
        return  $method === 'GET';
    }
    
    final public static function isPost(){
        $method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        $method = strtoupper($method);
	return $method === 'POST';
    }
    
    final public static function  checkMethodIsAllowed($allowedMethods = 'GET'){
        $allowedMethods = explode('|', $allowedMethods);
        $requestMethod = filter_input(INPUT_SERVER, 'REQUEST_METHOD');
        
        foreach ($allowedMethods as $method){
            $method = strtoupper($method);
            if($method == $requestMethod)
                return;
        }
        http_response_code(405);
        ob_clean();
        die('HTTP: 405 method not allowed.');
    }

    final public static function isHttps() {
            $c1 = filter_input(INPUT_SERVER, 'HTTPS') !== null;
            $c2 = filter_input(INPUT_SERVER, 'SERVER_PORT', FILTER_SANITIZE_NUMBER_INT);
            $c2 = intval($c2) === 443;

            if ($c1 || $c2) {
                    return true;
            }
            return false;
    }
    final public static function getRequestedPath() {
            $request = filter_input(INPUT_SERVER, 'REQUEST_URI');
            $request = substr($request, strlen(Config::PATH));
            
            return $request;
    }
    private function __construct() {}
}