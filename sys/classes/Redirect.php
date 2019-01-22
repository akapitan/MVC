<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Redirect
 *  Klasa preusmjeravanja
 * @author Aleksa
 */
final class Redirect {
    /*
     * Interno preusmjeravanje
     * @param string $link Relativna veza s unutarnjim resursom
     */
    final public static function to($link){
        ob_clean();
        header('Location' . Config::BASE . $link);
        die;
    }
    
    /*
     * Vanjsko preusmjeravanje
     * @param string $link Apsolutna veza na vanjski resurs
     */
    final public static function absolute($link){
        od_clean();
        header('Kication: ' . $link);
        die;
    }
    
}
