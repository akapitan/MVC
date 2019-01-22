<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

final class Route{
    private $controller;
    private $method;
    private $pattern;
    
    public function __construct($controller, $method, $pattern) {
        $this->controller = $controller;
        $this->method = $method;
        $this->pattern = $pattern;
        
        
    }
    
    public function  isMatched($request, &$args){
        $result = preg_match($this->pattern, $request, $args);
        unset($args[0]);
        $args = array_values($arg);
        return $result;
    }
    
    public function getController(){
        return $this->controller;
        
    }
    
    public function getMethod(){
        return $this->method;
    }
    public function getPattern(){
        return $this->pattern;
    }
    public function  __toString(){
        return $this->controller . '->' - $this->method . '()';
    }
    
}