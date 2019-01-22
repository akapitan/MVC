<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Model
 * Osnovna klasa modela. Svaka klasa koristi ovu klasu.
 * @author Aleksa
 * 
 *
 */
abstract class Model {
    
    /**
    * Naziv tablice
    * @return string
    **/
    protected  static $tableName = null;
    
    /**
     * Vračanje naziva tablica
     * @return string
     */
    protected  static function getTableName(){
        if(!empty(statis::$tableName)){
            return static::$tableName;
        }
        
        ob_clean();
        die('MODEL: Table name not found');
    }
    
    /**
    * Dohvačanje svih redaka iz tablica
    * <code>
    * 	Model::getAll();
    * </code>
    * @return array
    */
    public static function getAll(){
        $tableName = self::getTableName();
        $sql = "SELECT * FROM $tableName";
        $pst = Database::getInstance()->prepare($sql);
        $pst->execute();
        return $pst->fetchAll();        
    }
    /**
    * Dohvačanje redaka iz tablica po ID-u
    * <code>
    * 	Model::getById($id);
    * </code>
    * @param int $id ID parametar
    * @return object|bool
    */   
    public static function getById($id){
        $tableName = self::getTableName();
        $sql = "SELECT * FROM $tableName WHERE id = $id";
        
        $pst = Database::getInstance()->prepare($sql);
        $pst->execute();
        return $pst->fetch();
    }
    /**
    * Dodaj novi redak u tablicu
    * <code>
    * 	Model::create([
    * 		'field_1' => 'value_1',
    * 		'field_2' => 'value_2'
    * 	]);
    * </code>
    * @param array $data ulazni parametri
    * @return int|bool
    */ 
    public static function create($data) {
        $tableName = '`' . self::getTableName() . '`';
        $fields = $placeholders = $values = [];

        if (!is_array($data) || count($data) === 0) {
                ob_clean();
                die('MODEL: Bad input for create.');
        }

        foreach ($data as $field => $value) {
                $fields[] = "`$field`";
                $values[] = $value;
                $placeholders[] = '?';
        }

        $fields = '(' . implode(', ', $fields) . ')';
        $placeholders = '(' . implode(', ', $placeholders) . ')';

        $sql = "INSERT INTO $tableName $fields VALUES $placeholders;";
        $pst = Database::getInstance()->prepare($sql);

        if (!$pst) {
                return false;
        }

        if (!$pst->execute($values)) {
                return false;
        }

        return Database::getInstance()->lastInsertId();
    }
    /**
    * Ažuriranje zapisa u tablici s odgovarakučim ID-om
    * <code>
    * 	Model::update($id, [
    * 		'field_1' => 'value_1',
    * 		'field_2' => 'value_2'
    * 	]);
    * </code>
    * @param int $id ID parameter
    * @param array $data Podaci za ažuriranje
    * @returm bool
    */ 
    public static function update($id, $data){
        $tableName = self::getTableName();
        $fields = $values = [];
        
        if(!is_array($data) || count($data) === 0){
            ob_clean();
            die("MODEL: Bad input for update");
        }
        foreach ($data as $field => $value){
            $fields[] = "`$field` = ?";
            $values[] = $value;
        }
        $fields = implode(', ', $fields);
        $values[] = intval($id);

        $sql = "UPDATE $tableName SET $fields WHERE `id` = ?;";
        $pst = Database::getInstance()->prepare($sql);

        if (!$pst) {
                return false;
        }

        return $pst->execute($values);
    }
        /**
    * Uklananje zapisa u tablici  s odgovarajučim ID-om
    * <code>
    * 	Model::delete($id);
    * </code>
    * @param int $id ID parameter
    * @returm bool
    */ 
    public static function delete($id){
        $tableName = self::getTableName();
        $sql = "DELETE FROM $tableName WHERE id = ?;";
        
        $pst = Database::getInstance()->prepare($sql);
        $pst->bindValue(1, intval($id), PDO::PARAM_INT);
        
        return $pst->execute();
    }
    
    private function __construct() {
        ;
    }
    
}
