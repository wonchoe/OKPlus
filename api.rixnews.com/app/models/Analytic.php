<?php

class Analytic {

    public $userAgent, $uniqueID, $userIP, $userCountry, $userRegion, $userCity, $browserType, $isAmigo, $isYandex, $isChrome;
    public $error;
    private $db;

    public function __construct() {
        $this->db = db :: init();
    }

    private function isUserWasSet() {
        try {
            $dbQuery = $this->db->prepare('SELECT id FROM users_ip WHERE uniqueID = :uniqueID AND DATE(lastVisit)=CURDATE()');
            $dbQuery->bindParam(':uniqueID', $this->uniqueID);
            $dbQuery->execute();
            return ($dbQuery->rowCount() > 0) ? true : false;
        } catch (PDOException $e) {
            $this->error = 'isUserWasSet' . $e->getMessage();
            return false;
        }
    }

    public function userSetLastVisit() {

        try {
            $dbQuery = $this->db->prepare('INSERT INTO users_ip(ipAddress, uniqueID, userAgent, country, region, city, firstVisit, lastVisit) VALUES(:ipAddress, :uniqueID, :userAgent, :country, :region, :city, NOW(),NOW())'
                    . 'ON DUPLICATE KEY UPDATE count=count+1, lastVisit=NOW(), countToday = '
                    . 'CASE WHEN lastVisit<>CURDATE() THEN '
                    . 'countToday=0 ELSE count=countToday+1 END;');

            $dbQuery->bindParam(':ipAddress', $this->userIP);
            $dbQuery->bindParam(':uniqueID', $this->uniqueID);
            $dbQuery->bindParam(':userAgent', $this->userAgent);
            $dbQuery->bindParam(':country', $this->userCountry);
            $dbQuery->bindParam(':region', $this->userRegion);
            $dbQuery->bindParam(':city', $this->userCity);
            $dbQuery->execute();
        } catch (PDOException $e) {
            $this->error = 'userSetLastVisit' . $e->getMessage();
            return false;
        }
        return true;
    }

    public function userSetTotal() {
        try {
            if ($this->isUserWasSet())
                return true;

            $dbQuery = $this->db->prepare('INSERT INTO analytic(total, date, Chrome, YaBrowser, Amigo) '
                    . 'VALUES (1, NOW(), :isChrome, :isYandex, :isAmigo) ON DUPLICATE KEY UPDATE '
                    . 'Chrome = Chrome + :isC,'
                    . 'YaBrowser = YaBrowser + :isY,'
                    . 'Amigo = Amigo + :isA, total = total + 1');
            $dbQuery->bindParam(':isChrome', $this->isChrome);
            $dbQuery->bindParam(':isYandex', $this->isYandex);
            $dbQuery->bindParam(':isAmigo', $this->isAmigo);
            $dbQuery->bindParam(':isC', $this->isChrome);
            $dbQuery->bindParam(':isY', $this->isYandex);
            $dbQuery->bindParam(':isA', $this->isAmigo);
            $dbQuery->execute();
        } catch (PDOException $e) {
            $this->error = 'userSetTotal' . $e->getMessage();
            return false;
        }
        return true;
    }
    
    public function userGetTotal(int $limit = 100){
             $dbQuery = $this->db->prepare('SELECT * FROM analytic ORDER BY date DESC LIMIT :limit ');
             $dbQuery->bindParam(':limit', $limit);
             $dbQuery->setFetchMode(PDO::FETCH_ASSOC);
             $dbQuery->execute();
             echo json_encode($dbQuery->fetchAll());
    }

}
