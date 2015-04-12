<?php 

function init_curl()
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
    $http_header = array('Pragma: no-cache', 'Cache-Control: no-cache', 'Host: www.baidu.com');
    curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);

    // 补充其它属性
    curl_setopt($ch, CURLOPT_USERAGENT, CURL_USERAGENT);

    return $ch;
}

function curl_fetch($service_addr)
{
    $ch = init_curl();

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_URL, $service_addr);

    $result = curl_exec($ch);

    $status = array(
        'curl_code' => curl_errno($ch),
        'http_code' => curl_getinfo($ch, CURLINFO_HTTP_CODE), 
        'result'    => $result,
    );

    curl_close($ch);
    return $status;
}

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

    curl_close($ch);
    return $status;
}

function ops_log($subject, $content, $notify_ops = false)
{
    $timestamp = date('Y-m-d H:i:s', time());
    error_log("{$timestamp}\t{$subject} ${content}\n", 3, INFOLOG);
    if ($notify_ops) {
        ops_notify($subject, $content);
    }
}

function ops_notify($subject, $content)
{
    // $subject and $content must be urlencoded 
    $subject = substr(php_uname('n'), 0, -10) . ':' . $subject;
    $subject = urlencode(iconv('UTF-8', 'GBK', $subject));
    $content = urlencode(iconv('UTF-8', 'GBK', $content));

    $retry = 3;
    $alarm_url = sprintf(ALARM_URL . 'group_name=%s&subject=%s&content=%s',
            ALARM_ID, $subject, $content);
    do {
        $status = curl_fetch($alarm_url);
        if ($status['result'] == 'ok') {
            return true;
        }
        $retry -= 1;
    } while ($retry > 0);

    return false;
}

if (!defined('CURL_TIMEOUT_SEC'))           define('CURL_TIMEOUT_SEC',           30);
if (!defined('CURL_MAX_REDIRECT'))          define('CURL_MAX_REDIRECT',          3);
if (!defined('CURL_CONNECT_TIMEOUT_SEC'))   define('CURL_CONNECT_TIMEOUT_SEC',   5);
if (!defined('CURL_DNS_CACHE_TIMEOUT_SEC')) define('CURL_DNS_CACHE_TIMEOUT_SEC', 900);

if (!defined('CURL_ENCODING'))              define('CURL_ENCODING',  'identity');
if (!defined('CURL_USERAGENT'))             define('CURL_USERAGENT', 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1; Trident/4.0)');

if (!defined('INFOLOG'))   define('INFOLOG',   BASEPATH . '/info.log.' . date('Ymd'));
if (!defined('ALARM_ID'))  define('ALARM_ID',  'alarm_id');
if (!defined('ALARM_URL')) define('ALARM_URL', 'http://alarm.com/***?');

$ip_file   = $argv[1];
$html_path = $argv[2];
$ips       = file($ip_file);
foreach ($ips as $v) {
    $v = trim($v);
    echo $v . "\n";
    $c = curl_fetch("http://{$v}/");
    file_put_contents("{$html_path}/html.www.baidu.com." . $v . ".html", $c['result']);
}

?>