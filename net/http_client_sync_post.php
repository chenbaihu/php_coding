<?php

function curl_post($data, $service_addr, $header=array())
{
    $ch = curl_init();           // 也可以 curl_init($ service_addr); 就不用 CURLOPT_URL

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $service_addr);          
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch , CURLOPT_TIMEOUT, 10);     

    $ret       = curl_exec($ch);
    $errno     = curl_errno($ch);
    $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);
    if ($errno == 0 && $http_code == 200) {
        return $ret;
    }
    return '';
}


?>
