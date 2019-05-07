<?php

class AnalyticController {

    public $userAgent, $userIP, $userCountry, $userRegion, $userCity;

    public function saveUser() {
        $userAnalytic = new Analytic();
        $userAnalytic->userAgent = $this->userAgent;
        $userAnalytic->userIP = $this->userIP;
        $userAnalytic->userCountry = $this->userCountry;
        $userAnalytic->userRegion = $this->userRegion;
        $userAnalytic->userCity = $this->userCity;
        if (!$userAnalytic->userSetLastVisit()){
            echo $userAnalytic->error;
        }
    }

}
