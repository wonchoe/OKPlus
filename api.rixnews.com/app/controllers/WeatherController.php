<?php

class WeatherController {

    public function get($params) {
        $params = explode('&', $params);
        if ($data = file_get_contents('http://api.apixu.com/v1/forecast.json?q=' . $params[0] . ',' . $params[1] . '&key=04f44ea414f6499587d213957191004&lang=ru', true)) {
            $data = str_replace('64x64/', '', $data);
            $data = str_replace('//cdn.apixu.com/', '/icons/', $data);

            $obj = json_decode($data);

            if ($obj->location->name) {

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
