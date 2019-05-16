<?php

class DashboardController {

    public function show() {
      
        $username = (UsersController::checkJWT()) ? UsersController::checkJWT()->username : false;
       
        if (!$username) {
            header('Location: /');
        }
        include ROOT . '/app/views/common/dashboard.php';
    }

}
