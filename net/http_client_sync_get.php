<?php

function curl_get($service_addr)
{
    $ch = curl_init();          // 也可以 curl_init($service_addr); 就不用 CURLOPT_URL

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_URL, $service_addr);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

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
