<?php

class SourceController {

    private function setResult($r, $message = '') {
        echo json_encode(array('result' => $r, 'message' => $message));
    }

    public function edit($params = '') {

        if (!UserController::checkJWT('', $params)) {
            exit(json_encode(array('result' => false)));
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (file_exists(ROOT . 'config/code.js')) {
                copy(ROOT . 'config/code.js', ROOT . 'config/code_backup/' . date('Ymd_His') . '.js');
            }
            $code = isset($_POST['codeValue']) ? $_POST['codeValue'] : '';

            if (file_put_contents(ROOT . 'config/code.js', $code)) {
                $yui = new \YUI\Compressor();
                $script = file_get_contents(ROOT . 'config/code.js');
                $yui->setType(\YUI\Compressor::TYPE_JS);
                try {
                    $optimizedScript = $yui->compress($script);
                    file_put_contents(ROOT . 'config/code_compressed.js', $optimizedScript);
                } catch (Exception $e) {
                    $msg = $e->getMessage();
                    $msg = substr($msg, 0, strpos($msg, 'org.mozilla.javascript.EvaluatorException'));
                    $this->setResult(false, nl2br($msg));
                    exit;
                }
                $this->setResult(true, 'Successfully saved');
            } else {
                $this->setResult(false, 'Error saving');
            }

            exit;
        }
    }

    public function loadFile($params = '') {

        if (!UserController::checkJWT('', $params)) {
            exit(json_encode(array('result' => false)));
        }

        $fileName = ROOT . 'config/code.js';
        if (file_exists($fileName)) {
            $fileSize = round((filesize($fileName) / 1024), 2);
            $fileSizeCompressed = round((filesize(ROOT . 'config/code_compressed.js') / 1024), 2);
            $lastModified = filemtime($fileName);
            $file = file_get_contents($fileName);
            echo json_encode(array('result' => true,
                'data' => $file,
                'fileSize' => $fileSize,
                'fileSizeCompressed' => $fileSizeCompressed,
                'lastModifiedDate' => date('M Y D', $lastModified),
                'lastModifiedTime' => date('H:i:s', $lastModified)
                ));
        }
    }
    

    public static function getCompressed() {
        if (file_exists(ROOT . 'config/code_compressed.js')) {
            $file = file_get_contents(ROOT . 'config/code_compressed.js');
            return $file;
        } else {
            return false;
        }
    }    
//
//    public static function getCompressed() {
//        if (file_exists(ROOT . 'config/code_compressed.js')) {
//            $file = file_get_contents(ROOT . 'config/code_compressed.js');
//            $data = array("data" => $file,
//                'result' => true);
//            echo json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
//        } else {
//            json_encode(array(result => false));
//        }
//    }

}
