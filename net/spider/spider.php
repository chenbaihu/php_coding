<?php 
//------------------------------
function init_curl($hostname)
{
    $ch = curl_init();

    // 设置默认属性
    curl_setopt($ch, CURLOPT_NOBODY, false);
    curl_setopt($ch, CURLOPT_ENCODING, CURL_ENCODING);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_DNS_CACHE_TIMEOUT, CURL_DNS_CACHE_TIMEOUT_SEC);

    // 重定向级数限制
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_MAXREDIRS, CURL_MAX_REDIRECT);

    // 超时限制
    curl_setopt($ch, CURLOPT_TIMEOUT, CURL_TIMEOUT_SEC);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, CURL_CONNECT_TIMEOUT_SEC);

    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    // HTTP 相关请求头
    $host="Host: $hostname";
    //$http_header = array('Pragma: no-cache', 'Cache-Control: no-cache', 'Host: $hostname');
    $http_header = array('Pragma: no-cache', 'Cache-Control: no-cache', $host);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

    // 补充其它属性
    curl_setopt($ch, CURLOPT_USERAGENT, CURL_USERAGENT);

    return $ch;
}

//------------------------------
function curl_fetch($hostname,$service_addr,$ip)
{
    $ch = init_curl($hostname);

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_URL, $service_addr);

    $result = curl_exec($ch);

    $status = array(
        'curl_code' => curl_errno($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), 
        'result'    => $result,
    );
    $header = curl_getinfo($ch);
    $url       = $header['url'];
    $line_log  = "hostname=".  $hostname            . "\t";
    $line_log .= "ip=".        $ip                  . "\t";
    $line_log .= "url=".       $url                 . "\t";
    $line_log .= "http_code=". $status['http_code'] . "\t";
    $line_log .= "curl_code=". $status['curl_code'] . "\t";
    recode_run_log($line_log);
    
    curl_close($ch);
    return $status;
}

//------------------------------
function curl_post($service_addr, $data, $header=array())
{
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_URL, $service_addr);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($ch);

    $status = array(
        'curl_code' => curl_errno($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), 
        'result'    => $result,
    );
    $header = curl_getinfo($ch);
    $url       = $header['url'];
    $line_log  = "hostname=".  $hostname            . "\t";
    $line_log .= "ip=".        $ip                  . "\t";
    $line_log .= "url=".       $url                 . "\t";
    $line_log .= "http_code=". $status['http_code'] . "\t";
    $line_log .= "curl_code=". $status['curl_code'] . "\t";
    recode_run_log($line_log);

    curl_close($ch);
    return $status;
}

$run_log_name="./header_info/spider_". date('Y-m-d') .".log";
function recode_run_log($line_log, $file_name=__FILE__, $line_num=__LINE__) {
    global $run_log_name;    
    error_log(date("Y-m-d H:i:s")."\t[".$file_name.":".$line_num."]\t".$line_log."\n", 3, $run_log_name);
}

if (!defined('CURL_TIMEOUT_SEC'))           define('CURL_TIMEOUT_SEC',           30);
if (!defined('CURL_MAX_REDIRECT'))          define('CURL_MAX_REDIRECT',          10);
if (!defined('CURL_CONNECT_TIMEOUT_SEC'))   define('CURL_CONNECT_TIMEOUT_SEC',   5);
if (!defined('CURL_DNS_CACHE_TIMEOUT_SEC')) define('CURL_DNS_CACHE_TIMEOUT_SEC', 900);

if (!defined('CURL_ENCODING'))              define('CURL_ENCODING',  'identity');
if (!defined('CURL_USERAGENT'))             define('CURL_USERAGENT', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)');

//$c = curl_fetch($host, "http://{$ip}/", $ip);
$c = curl_fetch("www.baidu.com", "http://123.254.111.182/", "123.254.111.182");
var_dump($c);
    
