<?php

class SourceController {

    public function edit() {
        
        $username = (UsersController::checkJWT()) ? UsersController::checkJWT()->username : false;

        if (!$username) {
            header('Location: /');
        }
        
        include(ROOT . 'app/views/source/edit.php');
    }

}
