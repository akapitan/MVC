<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Database
 * Klasa za upravljanje bazom podataka. Upravljanje vezom.
 * @author Aleksa
 */
class Database {
    
    /**
    * PDO handler
    * @var PDO|null
    */
    private static $dbh = null;
        
    /**
    * Uspostavlja konekciju sa BP poslužiteljam korističe Singelton pattern i vraća instancu POD rukovoditelja.
    *@return POD 
    */
    final public static function getInstance(){
        if(self::$dbh === null){
            $dsn = 'mysql:host=' . Config::DB_HOST . ';dbname=' . Config::DB_NAME . ';charset=utf8';
            try {
                self::$dbh = new PDO($dsn, Config::DB_USER, Config::DB_PASS, [PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_SILENT]);
            } catch (PDOException $ex) {
                error_log($ex->getMessage());
                ob_clean();
                die('DATABASE: Connection error.');
            }
            return self::$dbh;
        }
    }
    
    
}
