<?php

namespace App\Controllers;

use App\Models\User;

class LoginController {

 
    public function showLoginForm() {
        session_start();

        
        $disabled = isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3;

        global $mustache;
        echo $mustache->render('login-form', ['disabled' => $disabled]);
    }


    public function login() {
        session_start();

     
        if (isset($_SESSION['login_attempts']) && $_SESSION['login_attempts'] >= 3) {
            global $mustache;
            echo $mustache->render('login-form', ['error' => 'Too many failed attempts. Login is disabled.', 'disabled' => true]);
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

           
            $user = User::getByUsername($username);

            if ($user && password_verify($password, $user['password_hash'])) {
              
                $_SESSION['is_logged_in'] = true;
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['login_attempts'] = 0; 

               
                header("Location: /welcome");
                exit;
            } else {
              
                $_SESSION['login_attempts'] = isset($_SESSION['login_attempts']) ? $_SESSION['login_attempts'] + 1 : 1;

                global $mustache;
                echo $mustache->render('login-form', ['error' => 'Invalid username or password', 'disabled' => false]);
            }
        }
    }

   
    public function showWelcomePage() {
        session_start();

     
        if (!isset($_SESSION['is_logged_in'])) {
            header("Location: /login-form");
            exit;
        }

   
        $users = User::getAll();

        global $mustache;
        echo $mustache->render('welcome', ['users' => $users]);
    }

   
    public function logout() {
        session_start();
        session_destroy();
        header("Location: /login-form");
        exit;
    }

   
    public function retry() {
        session_start();
      
        $_SESSION['login_attempts'] = 0;

        
        header("Location: /login-form");
        exit;
    }
}
