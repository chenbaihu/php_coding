<?php
function init_curl($timeout_s = 900, $connect_timeout_s = 20, $max_redirect = 5)
{
	$ch = curl_init();
	
	// 设置默认属性
	curl_setopt($ch, CURLOPT_NOBODY, false);
	curl_setopt($ch, CURLOPT_NOSIGNAL, true);
	curl_setopt($ch, CURLOPT_NOPROGRESS, true);
	curl_setopt($ch, CURLOPT_BINARYTRANSFER, true);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
	
	// 超时限制
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout_s);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $connect_timeout_s);
	
	// 重定向级数限制
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	curl_setopt($ch, CURLOPT_MAXREDIRS, $max_redirect);
	
	// HTTP 相关请求头
	$http_header = array(
		'Pragma: no-cache',
		'Cache-Control: no-cache',
		'Accept-Language: zh-cn',
		'Connection: Keep-Alive',
	);
	
	curl_setopt($ch, CURLOPT_HTTPHEADER, $http_header);
	
	return $ch;
}

function download_file($service_addr, $section_name, $retry=3)
{
	$ch = init_curl();
	
	$curl_swap_file = tempnam("./download_tmpfile_{$section_name}_");
    if (($curl_swap_fd = fopen($curl_swap_file, 'wb')) === false) {
        echo("download_file fopen $curl_swap_file failed\n");
        return false;
    }   

    curl_setopt($ch, CURLOPT_HTTPGET, true);
    curl_setopt($ch, CURLOPT_FILE, $curl_swap_fd);
    curl_setopt($ch, CURLOPT_URL, $service_addr);
	
	do {
        $ret = curl_exec($ch);

        $curl_error = curl_error($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($curl_error === '' && $http_code === 200) {
			echo("download file $section_name succ, download to $curl_swap_file\n");
            fclose($curl_swap_fd);
            curl_close($ch);
            return $curl_swap_file;
        }   

        sleep(3);
        $retry--;
    } while ($retry > 0); 

    curl_close($ch);
	
	fclose($curl_swap_fd);
    unlink($curl_swap_file);
	
	return false;
}

download("http://www.baidu.com", "baidu.html");

?>
