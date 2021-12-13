<?php

class User
{

    public $_id;
    public $_login;
    public $_email;
    public $_firstname;
    public $_lastname;

    public function __construct()
    {
    }

    public function register(string $login, string $password, string $email, string $firstname, string $lastname)
    {

        $connexion = new PDO('mysql:host=localhost;dbname=classes','root','root');        
        $requete = $connexion->prepare("INSERT INTO `utilisateurs`(`login`, `password`, `email`, `firstname`, `lastname`) VALUES ('$login','$password','$email','$firstname','$lastname')");
        $requete->execute();
        $user = [$login, $password, $email, $firstname, $lastname];
        return $user;
    }

    public function connect(string $login, string $password)
    {
        
        $connexion = new PDO('mysql:host=localhost;dbname=classes','root','root');        
        $requete = $connexion->prepare("SELECT * FROM `utilisateurs` WHERE login='$login' AND password='$password'");
        $requete->execute();
        $res = $requete->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($res)) {
            $this->_login = $login;
            $this->_password = $password;
            $this->_email = $res[0]['email'];
            $this->_firstname = $res[0]['firstname'];
            $this->_lastname = $res[0]['lastname'];
            $this->_id = $res[0]['id'];
            session_start();
            $_SESSION['login'] = $login;
            echo 'Utilisateur connecté';
        } else {
            echo 'Utilisateur introuvable';
        }
    }

    public function disconnect()
    {
        session_start();
        unset($_SESSION);
        session_destroy();
    }

    public function delete()
    {
        $connexion = new PDO('mysql:host=localhost;dbname=classes','root','root');        
        $requete = $connexion->prepare("DELETE FROM `utilisateurs` WHERE `login`='$this->_login'");
        $requete->execute();
        $this->disconnect();
    }

    public function update($login, $password, $email, $firstname, $lastname)
    {   
        $connexion = new PDO('mysql:host=localhost;dbname=classes','root','root');        
        $requete = $connexion->prepare("UPDATE `utilisateurs` SET `login`='$login',`password`='$password',`email`='$email',`firstname`='$firstname',`lastname`='$lastname' WHERE `login`='$this->_login'");
        $requete->execute();
        $this->_login = $login;
        $this->_password = $password;
        $this->_email = $email;
        $this->_firstname = $firstname;
        $this->_lastname = $lastname;
    }

    public function isConnected()
    {   $connect = FALSE;
        if (isset($_SESSION['login'])) {
            $connect = TRUE;
            return $connect;
        }
        else {
            return $connect;
        }
    }

    public function getAllInfos(){
        $all = ['login' => $this->_login, 'email' => $this->_email, 'firstname' => $this->_firstname, 'lastname' => $this->_lastname ];
        return $all;
    }

    public function getLogin(){
        return $this->_login;
    }

    public function getEmail(){
        return $this->_email;
    }

    public function getFirstname(){
        return $this->_firstname;
    }

    public function getLastname(){
        return $this->_lastname;
    }




}

// $user = new User();
// // $user->register("aa","aa","aa","aa","aa");
// $user->connect("aa","aa");
// $user->delete();
// // $user->update("test","test","test2","test2","test2");
// // $user->disconnect();