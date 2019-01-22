<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Controller
 *
 * @author Aleksa
 */
abstract class Controller {
    
    private $data = [];
    
    abstract public function index();
    
    final protected function  set($key, $value){
        $this->data[$key] = $value;
    }
    
    final public function  getData(){
        return $this->data;
    }
    
    public function  __pre(){
        
    }
    
    public function  __post(){
        
    }
    
}
