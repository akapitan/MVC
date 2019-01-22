<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserModel
 *
 * @author Aleksa
 */
class UserModel extends Model{
    
    /**     
     *  Naziv tablice
     * @var string
     */
    protected static $tableName = 'users';
    
    /**     
     *  Provjeri autentičnost korisnika po emailu i passwordu
     * @param string $email Email korisnika
     * @param string $password Zaporko korisnika
     * @return object 
     */
    public static function  getByEmailAndPassword($emal, $password){
        $tableName = self::$tableName;
        $sql = "SELECT * FROM $tableName WHERE 'email' = ? AND password = ? LIMIT 1";
        
        $pst = Database::getInstance()->prepare($sql);
        $pst->bindValue(1, $email, PDO::PARAM_STR);
        $pst->bindValue(2, $password, PDO::PARAM_STR);
        $pst->execute();

        return $pst->fetch();
    }
            
}
