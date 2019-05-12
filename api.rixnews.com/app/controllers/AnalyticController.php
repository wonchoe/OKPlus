<?php

class AnalyticController {

    public $userAgent, $uniqueID, $userIP, $userCountry, $userRegion, $userCity, $chromeType, $isAmigo, $isYandex, $isChrome;
    public $userAnalytic;

    public function __construct() {
        $this->userAnalytic = new Analytic();
    }

    public function saveUserAnalytic() {

        $this->userAnalytic->userAgent = $this->userAgent;
        $this->userAnalytic->uniqueID = $this->uniqueID;
        $this->userAnalytic->userIP = $this->userIP;
        $this->userAnalytic->userCountry = $this->userCountry;
        $this->userAnalytic->userRegion = $this->userRegion;
        $this->userAnalytic->userCity = $this->userCity;
        $this->userAnalytic->isYandex = $this->isYandex;        
        $this->userAnalytic->isAmigo = $this->isAmigo;
        $this->userAnalytic->isChrome = $this->isChrome;

        if (!$this->userAnalytic->userSetTotal()) {
            return $this->userAnalytic->error;
        }        
        
        if (!$this->userAnalytic->userSetLastVisit()) {
            return $this->userAnalytic->error;
        }
        
    }

    public function getTotal($params) {
        $params = explode('&', $params);
        echo $this->userAnalytic->userGetTotal($params[0]);        
    }

}
