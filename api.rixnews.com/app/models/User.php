<?php

class User {

    public static function checkAge($uID) {
        $db = db::init();
        $query = $db->prepare('SELECT firstVisit FROM users_ip WHERE uniqueID=:uID');
        $query->bindParam(':uID', $uID);
        $query->execute();
        $query->setFetchMode(PDO::FETCH_ASSOC);
        return $query->fetchAll()[0]['firstVisit'];
    }

    public static function isUsernameExist(string $username) {
        $db = db::init();
        $query = $db->prepare('SELECT * FROM users WHERE username=:username');
        $query->bindParam(':username', $username);
        $query->execute();
        if ($query->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function isEmailExist(string $email) {
        $db = db::init();
        $query = $db->prepare('SELECT * FROM users WHERE email=:email');
        $query->bindParam(':email', $email);
        $query->execute();
        if ($query->rowCount() > 0)
            return true;
        else
            return false;
    }

    public static function getUserByLogin(string $username) {
        $db = db::init();
        $query = $db->prepare('SELECT * FROM users where username=:username');

        $query->bindParam(':username', $username);
        $query->execute();
        if ($query->rowCount() > 0)
            return json_decode(json_encode($query->fetchAll(PDO::FETCH_ASSOC)), FALSE)[0];
    }

    public static function addUser(string $username, $email, $password) {
        $password = password_hash($password, PASSWORD_DEFAULT);

        try {
            $db = db::init();
            $query = $db->prepare('INSERT INTO users(username,email,password) VALUES(:username, :email, :password) ');
            $query->bindParam(':username', $username);
            $query->bindParam(':email', $email);
            $query->bindParam(':password', $password);

            if (!$query->execute())
                $errors['errorRequest'] = $query->errorInfo();
        } catch (PDOException $e) {
            $errors['errorException'] = $e->getMessage();
        }
        if (!empty($errors)) {
            return json_encode($errors);
        }

        return json_encode(array('success' => true));
    }

}
