<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of GomeController
 *
 * @author Aleksa
 */
class HomeController extends Controller{

    /**
     * Ruta: /
     * @return void
     */
    public function  index(){
        //postavljanje naslova
        $this->set('title', 'Home');
        
        //Uzmi podatke iz baze podataka
        $user = UserModel::getById(Session::get(Config::USER_COOKIE));
        
        //formatiranje podataka za prikaz
        if ($user) {
        $userParsed = null;
            if (!empty($user->first_name) && !empty($user->last_name)) {
            $userParsed = $user->first_name . ' ' . $user->last_name;
            } elseif (!empty($user->first_name)) {
                    $userParsed = $user->first_name;
            } elseif (!empty($user->last_name)) {
                    $userParsed = $user->last_name;
            } else {
                    $userParsed = 'N/A';
            }
            $this->set('user', $userParsed);
        } else {
            $this->set('user', false);
        }
        
        
    }
    
    /**
     * Ruta: /login/
     * @return void
     */
    public function login(){
        //postavljanje naslova
        $this->set('title', 'Login');
        
        //Zaustavite daljnju obradu zahtjeva u slučaju da HTTP metoda nije prikladna
        if(!Http::isPost()){
            if(Session::get(Config::USER_COOKIE) !== false){
                Redirect::to('');
            }
            return;
        }
        //Dohvaćanje podataka iz HTTP POST varijabli
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        
        //Provjera valjanosti podataka
        if (empty($email) || empty($password) || strlen($email) > 255) {
                $this->set('message', 'Error #1!');
                return;
        }

        // Provjera dodatnih podataka
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->set('message', 'Error #2!');
            return;
        }
        // Lozinka hash vrijednosti
        $password = Crypto::sha512($password, true);
        
        //Preuzimanje podataka iz baza podataka, autentifikacija korisnika
        $user = UserModel::getByEmailAndPassword($email, $password);

        //Postavljanje sesije u slučaju uspješne provjere autentičnosti
        if ($user) {
                Session::set(Config::USER_COOKIE, intval($user->id));
                Redirect::to('');
        } else {
                $this->set('message', 'Error #3!');
                sleep(2);
                return;
        }
    }
    /**
     * Ruta: /logout/
     * @return void
     */
    public function logout(){
        
    }
    
    /**
     * Ruta: 404 Page Not Found
     * @return void
     */
    public function e404() {
            
            http_response_code(404);

            
            ob_clean();
            die('HTTP: 404 not found.');
    }
}