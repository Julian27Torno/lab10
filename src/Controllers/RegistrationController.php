<?php

namespace App\Controllers;

use App\Models\User;

class RegistrationController {
    

    public function showRegistrationForm() {
        global $mustache;
        echo $mustache->render('registration-form');
    }

    
    public function register() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            $username = $_POST['username'];
            $email = $_POST['email'];
            $first_name = $_POST['first_name'];
            $last_name = $_POST['last_name'];
            $password = $_POST['password'];
            $password_confirm = $_POST['password_confirm'];

            $errors = [];

          
            if (empty($username) || empty($email) || empty($password) || empty($password_confirm)) {
                $errors[] = "All fields are required.";
            }

         
            if ($password !== $password_confirm) {
                $errors[] = "Passwords do not match.";
            }

        
            if (strlen($password) < 8) {
                $errors[] = "Password must be at least 8 characters long.";
            }
            if (!preg_match('/[0-9]/', $password)) {
                $errors[] = "Password must contain at least one numeric character.";
            }
            if (!preg_match('/[A-Za-z]/', $password)) {
                $errors[] = "Password must contain at least one non-numeric character.";
            }
            if (!preg_match('/[\W]/', $password)) {
                $errors[] = "Password must contain at least one special character (!@#$%^&*).";
            }

            if (count($errors) > 0) {
              
                global $mustache;
                echo $mustache->render('registration-form', ['errors' => $errors]);
            } else {
       
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

              
                User::register($username, $email, $hashed_password, $first_name, $last_name);

          
                echo "Successful Registration! <a href='/login-form'>Proceed to Login</a>";
            }
        }
    }
}
