<?php

use \Firebase\JWT\JWT;

class UserController {
    
    public static function checkAge($uniqueID = ''){
        //$res = User::checkAgeDB($uniqueID);
        $db = db::init();
        $query = $db->prepare('SELECT * FROM users WHERE uniqueID=:uID');
        $query->bindParam(':uID', $uID);
        $query->execute();
        return $query->fetchAll();        
        return $res;
    }

    public static function checkJWT($jwt = '', $params = '') {
        try {
            $params = explode('=', $params);
            $jwt = ($params[0] == 'jwt') ? $params[1] : '';

            if (empty($jwt))
                $jwt = isset($_COOKIE['JWT']) ? $_COOKIE['JWT'] : '';

            return JWT::decode($jwt, SECRET_KEY, array('HS256'));
        } catch (Exception $e) {
            return false;
        }
    }

    private function checkPassword(string $p1, $p2) {
        if (preg_match('/^[A-Za-z0-9]{6,32}$/', $p1) && ($p1 == $p2))
            return $p1;
        else
            return false;
    }

    private function checkEmail(string $email) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL))
            if (user::isEmailExist($email)) {
                return false;
            } else
                return $email;
    }

    private function checkUsername(string $username) {
        if (preg_match('/^[A-Za-z0-9]{6,32}$/', $username))
            if (!user::isUsernameExist($username))
                return $username;
            else
                return false;
    }

    private function generateGWT(string $user = '') {
        $token = array(
            "iss" => "http://api.rixnews.com",
            "aud" => "http://api.rixnews.com",
            "iat" => time(),
            "nbf" => time(),
            "username" => $user
        );
        return JWT::encode($token, SECRET_KEY);
    }

    public function login() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            if ($data->login && $data->password) {
                $user = user::getUserByLogin($data->login);
                if (!empty($user)) {
                    if (password_verify($data->password, $user->password)) {
                        echo json_encode(array('JWT' => $this->generateGWT($user->username)));
                    } else
                        echo json_encode(array('result' => false));
                } else
                    echo json_encode(array('result' => false));
            } else
                echo json_encode(array('result' => false));
        }
    }

    public function setNew() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'));
            $errors = array();
            $username = isset($data->login) ? $this->checkUsername(trim($data->login)) : false;
            $email = isset($data->email) ? $this->checkEmail(trim($data->email)) : false;
            $invitecode = isset($data->invitecode) ? (INVITECODE == $data->invitecode) : false;
            $password = (isset($data->password) && isset($data->repassword)) ? $this->checkPassword($data->password, $data->repassword) : false;

            if (!$username)
                $errors['login'] = false;
            if (!$email)
                $errors['email'] = false;
            if (!$invitecode)
                $errors['invitecode'] = false;
            if (!$password) {
                $errors['password'] = false;
                $errors['repassword'] = false;
            }

            if (!empty($errors)) {
                echo json_encode($errors);
                return;
            }

            echo json_encode(array('JWT' => $this->generateGWT($username)));
            user::addUser($username, $email, $password);
        }
    }

}
