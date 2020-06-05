<?php

class User {
    
    private $id;
    private $name;
    private $surname;
    private $username;
    private $email;
    
    public function __construct($id, $name, $surname, $username, $email) {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
    }
    
    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function getUsername() {
        return $this->username;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setId($id): void {
        $this->id = $id;
    }

    public function setName($name): void {
        $this->name = $name;
    }

    public function setSurname($surname): void {
        $this->surname = $surname;
    }

    public function setUsername($username): void {
        $this->username = $username;
    }

    public function setEmail($email): void {
        $this->email = $email;
    }    
}
