<?php 
//curl 多线程抓取 

//resource curl_multi_init ( void )                       
//返回一个新cURL批处理句柄；返回值：成功时返回一个cURL批处理句柄，失败时返回FALSE。

//void curl_multi_close ( resource $mh )             
//关闭一组curl句柄；

//int curl_multi_add_handle ( resource $mh , resource $ch )          
//向curl批处理会话中添加单独的curl句柄，即：增加 ch 句柄到批处理会话mh ;ch 由 curl_init() 返回的 cURL 句柄。mh 由 curl_multi_init() 返回的 cURL 多个句柄。
//返回值：成功时返回0，失败时返回CURLM_XXX之一的错误码。

//int curl_multi_remove_handle ( resource $mh , resource $ch )     
//移除curl批处理句柄资源中的某个句柄资源，即：从给定的批处理句柄mh中移除ch句柄。当ch句柄被移除以后，仍然可以合法地用curl_exec()执行这个句柄。当正在移除的句柄正在被使用，在处理的过程中所有的传输任务会被终止。
//返回值：成功时返回一个cURL句柄，失败时返回FALSE。     

//int curl_multi_exec ( resource $mh , int &$still_running );          
//处理在栈中的每一个句柄。 这个方法可以在需要读写数据时被调用。 

//int curl_multi_select ( resource $mh [, float $timeout = 1.0 ] )         
//阻塞直到cURL批处理连接中有活动连接。 $timeout的单位是秒s
//返回值：成功时返回描述符集合中活动描述符的数量。失败时，select失败时返回-1，否则返回超时(从底层的select系统调用)。

/*
 * curl 多线程
 * @param array $array 并行网址
 * @param int $timeout 超时时间
 * @return array
 **/
function curl_http($array, $timeout) {
    $res = array();

    $mh = curl_multi_init();//创建多个curl语柄
    $startime = getmicrotime();

    foreach($array as $k=>$url){
        $conn[$k]=curl_init($url);

        curl_setopt($conn[$k], CURLOPT_TIMEOUT, $timeout);  //设置超时时间
        curl_setopt($conn[$k], CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($conn[$k], CURLOPT_MAXREDIRS, 7 );      //HTTP定向级别
        curl_setopt($conn[$k], CURLOPT_HEADER, 0);          //这里不要header，加块效率
        curl_setopt($conn[$k], CURLOPT_FOLLOWLOCATION, 1);  //302 redirect
        curl_setopt($conn[$k], CURLOPT_RETURNTRANSFER, 1);

        curl_multi_add_handle ($mh, $conn[$k]);
    }

    //防止死循环耗死cpu 这段是根据网上的写法
    do {
        $mrc = curl_multi_exec($mh, $active);       //当无数据，active=true
    } while ($mrc == CURLM_CALL_MULTI_PERFORM);     //当正在接受数据时

    while ($active and $mrc == CURLM_OK) {          //当无数据时或请求暂停时，active=true
        if (curl_multi_select($mh) != -1) {
            do {
                $mrc = curl_multi_exec($mh, $active);
            } while ($mrc == CURLM_CALL_MULTI_PERFORM);
        }
    }

    foreach ($array as $k => $url) {
        curl_error($conn[$k]);
        $res[$k]=curl_multi_getcontent($conn[$k]);    //获得返回信息
        $header[$k]=curl_getinfo($conn[$k]);          //返回头信息
        curl_close($conn[$k]);                        //关闭语柄
        curl_multi_remove_handle($mh  , $conn[$k]);   //释放资源
    }

    curl_multi_close($mh);

    $endtime = getmicrotime();
    $diff_time = $endtime - $startime;

    return array(
        'diff_time'=>$diff_time,
        'return'=>$res,
        'header'=>$header      
    );
}

//计算当前时间
function getmicrotime() {
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
}

//测试一下，curl 三个网址
$array = array(
            "http://www.weibo.com/",
            "http://www.renren.com/",
            "http://www.qq.com/"
            );

$data = curl_http($array, '10');

var_dump($data);//输出

//echo($data['diff_time']."\n");
//var_dump($data['header']);

?>
