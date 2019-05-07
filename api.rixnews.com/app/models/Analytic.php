<?php

class Analytic {
    
    public $userAgent, $userIP, $userCountry, $userRegion, $userCity;
    public $error;
          
    public function userSetLastVisit() {
        $db = db :: init();
        try{
        $dbquery = $db->prepare('INSERT INTO users_ip(ipAddress, userAgent, country, region, city, firstVisit, lastVisit) VALUES(:ipAddress, :userAgent, :country, :region, :city, NOW(),NOW())'
                . 'ON DUPLICATE KEY UPDATE countToday=countToday+1, lastVisit=NOW(), count = '
                . 'CASE WHEN lastVisit<>CURDATE() THEN '
                . 'count=0 ELSE count=count+1 END;');
        
        $dbquery->bindParam(':ipAddress', $this->userIP);
        $dbquery->bindParam(':userAgent', $this->userAgent);
        $dbquery->bindParam(':country', $this->userCountry);
        $dbquery->bindParam(':region', $this->userRegion);
        $dbquery->bindParam(':city', $this->userCity);                
        $dbquery->execute();
        }
        catch(PDOException $e){
            $this->error = $e->getMessage();
            return false;
        }
        return true;
        
    }

}
