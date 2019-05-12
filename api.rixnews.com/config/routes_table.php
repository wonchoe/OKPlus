<?php

return array("weather/get/lat=([\W][0-9]{1,3}[.][0-9]{1,10}|[0-9]{1,3}[.][0-9]{1,10})&lon=([\W]{1}[0-9]{1,3}[.][0-9]{1,10}|[0-9]{1,3}[.][0-9]{1,10})&hash=([A-Za-z0-9]{32})&uniqueID=([A-Za-z0-9]{16})$" => "weather/get/$1&$2&$3&$4",
    "analytic/getTotal/count=([0-9]{1,3})$" => "analytic/getTotal/$1",
    "source/getcompressed" => "source/getCompressed",
    "source/get" => "source/loadFile",
    "source" => "source/edit",
    "user/new" => "user/setNew",
    "user/login" => "user/login",
    "" => "index/version");