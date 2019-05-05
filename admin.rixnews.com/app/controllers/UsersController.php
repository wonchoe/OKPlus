<?php

use \Firebase\JWT\JWT;

class UsersController {

    public function loginForm() {

        $username = (UsersController::checkJWT()) ? UsersController::checkJWT()->username : false;

        if ($username) {
            header('Location: /source/edit');
        }

        include ROOT . 'app/views/users/loginForm.php';
    }

    public static function checkJWT() {
        $jwt = isset($_COOKIE['JWT']) ? $_COOKIE['JWT'] : '';
        try {
            return JWT::decode($jwt, SECRET_KEY, array('HS256'));
        } catch (Exception $e) {
            return false;
        }
    }

}
