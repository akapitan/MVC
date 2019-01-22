<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Session
 *
 * @author Aleksa
 */
final class Session {
    
    final public static function  begin (){
        if(Http::isHttps()){
            session_set_cookie_params(0, '/','', true, true);
        }else{
            session_set_cookie_params(0, '/'.'', false, true);
        }
        
        session_start();
    }
    final public static function end(){
        $_SESSION = [];
        session_destroy();
    }
    
    final public static function get($key){
        if(isset($_SESSION[$key])){
            return $_SESSION[$key];
        }
        return false;
    }
    
    private function __construct() {
        
    }
}


