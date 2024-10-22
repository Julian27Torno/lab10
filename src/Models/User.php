<?php

namespace App\Models;

use PDO;

class User {

   
    public static function getAll() {
        global $conn;

        
        $stmt = $conn->query("SELECT * FROM users");

       
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

  
    public static function getByUsername($username) {
        global $conn;
        
        
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username);
        $stmt->execute();

       
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }


    public static function register($username, $email, $password_hash, $first_name, $last_name) {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO users (username, email, password_hash, first_name, last_name, created_at) 
            VALUES (:username, :email, :password_hash, :first_name, :last_name, NOW())");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->execute();
    }
}
