<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


spl_autoload_register(function($className){
    $path = '';
    echo $className . '<br>';
    if (file_exists('./sys/classes/' . $className . '.php')) {

            $path = './sys/classes/' . $className . '.php';
    } elseif (preg_match('|^(?:[A-Z][a-z]+)+Controller$|', $className)) {

            $path = './app/controllers/' . $className . '.php';
    } elseif (preg_match('|^(?:[A-Z][a-z]+)+Model$|', $className)) {

            $path = './app/models/' . $className . '.php';
    } elseif ($className === 'Config') {

            $path = './sys/Config.php';
    } else {

            die('AUTOLOAD: Class not found.');
    }

    if (file_exists($path)) {

            require_once $path;
            return true;
    }

    die('AUTOLOAD: File not found.');
});
