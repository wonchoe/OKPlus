<?php

class WeatherController {

    public function get($params) {
        $params = explode('&', $params);
        if ($data = file_get_contents('http://api.apixu.com/v1/forecast.json?q=' . $params[0] . ',' . $params[1] . '&key=04f44ea414f6499587d213957191004&lang=ru', true)) {
            $data = str_replace('64x64/', '', $data);
            $data = str_replace('//cdn.apixu.com/', '/icons/', $data);

            $obj = json_decode($data);

            if ($obj->location->name) {
                $ua = filter_input(INPUT_SERVER, 'HTTP_USER_AGENT', FILTER_SANITIZE_SPECIAL_CHARS | FILTER_SANITIZE_ENCODED);
                $user = new AnalyticController();
                //$user->chromeType = strpos($ua, 'YaBrowser') ? 3 : (strpos($ua, 'Amigo') ? 2 : 1);
                $user->isYandex = strpos($ua, 'YaBrowser') ? 1 : 0;
                $user->isAmigo = strpos($ua, 'Amigo') ? 1 : 0;
                $user->isChrome = ((!strpos($ua, 'Amigo')) && (!strpos($ua, 'YaBrowser'))) ? 1 : 0;
                $user->uniqueID = $params[3] ?? 'none';
                $user->userAgent = $ua;
                $user->userIP = (filter_var($_SERVER['REMOTE_ADDR'], FILTER_VALIDATE_IP)) ? $_SERVER['REMOTE_ADDR'] : '0.0.0.0';
                $user->userCountry = $obj->location->country ?? 'Unknown';
                $user->userRegion = $obj->location->region ?? 'Unknown';
                $user->userCity = $obj->location->name ?? 'Unknown';
                echo $user->saveUserAnalytic();


                if (file_exists(ROOT . 'config/code_compressed.js')) {
                    $hash = md5_file(ROOT . 'config/code_compressed.js');
                    if ($hash != $params[2]) {
                        $obj->template = (SourceController::getCompressed()) ? SourceController::getCompressed() : '';
                        $obj->hash = $hash;
                    }
                }
                $obj->result = true;
            } else
                $obj->result = false;

            echo json_encode($obj, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        }
        else {
            $data = array('result' => false);
            echo json_encode($data);
        }
    }

}
