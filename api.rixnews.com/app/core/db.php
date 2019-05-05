<?php

class db {

    public static function init() {
        try {
            $params = include(ROOT . 'config/dbconfig.php');
            extract($params);
            return new PDO('mysql: host=localhost; dbname=' . $dbName . '; charset=' . $dbCharset . ';', $dbUser, $dbPassword);
        } catch (PDOException $ex) {
            return $ex->getMessage();
        }
    }

}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

