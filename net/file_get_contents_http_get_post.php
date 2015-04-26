<?php

// http get

$url='http://www.domain.com/'; 
$html = file_get_contents($url); 
echo $html; 

// http pos
$data = array ('foo' => 'bar'); 
$data = http_build_query($data);            // 生成url-encode后的请求字符串，将数组转换为字符串，构造POST请求正文数据

$opts = array (                             // 构造POST请求HTTP报头
    'http' => array ( 
        'method' => 'POST', 
        'header'=> "Content-type: application/x-www-form-urlencoded\r\n" .  "Content-Length: " . strlen($data) . "\r\n", 
        'content' => $data  
    ) 
); 

$context = stream_context_create($opts);  // 构造HTTP请求

$html = file_get_contents('http://localhost/e/admin/test.html', false, $context); 
echo $html; 


?>
