<?php

/////////////////
date_default_timezone_set                 //设置默认时区 bool date_default_timezone_set(string timezone_identifier);
date_default_timezone_get                 //获取默认时区 string date_default_timezone_get(void);

例如:
    date_default_timezone_set("Asia/Chongqing");

////////////////
echo time();                              //获取当前秒数


//////////////////
$date = date("Y-m-d H:i:s");
echo "date=$date\n";

echo date("Y-m-d H:i:s", time());


/////////////////
string strftime ( string $format [, int $timestamp = time() ] )    //返回用给定的格式字串对给出的 timestamp 进行格式输出后的字符串。如果没有给出时间戳则用当前的本地时间。


////////////////
echo strtotime("now")."\n";
echo strtotime("10 September 2000")."\n";
echo strtotime("+1 day")."\n";
echo strtotime("+1 week"). "\n";
echo strtotime("+1 week 2 days 4 hours 2 seconds"). "\n";
echo strtotime("next Thursday"). "\n";
echo strtotime("last Monday")."\n";

echo date("Y-m-d H:i:s", strtotime("last Thursday"));


//////////////////
//gettimeofday — 取得当前时间：
chenbaihu~$php -r 'print_r(gettimeofday());'
Array
(
 [sec] => 1390806225
 [usec] => 273220
 [minuteswest] => -480
 [dsttime] => 0
 )

/////////////////
//getdate — 取得日期／时间信息：
chenbaihu~$ php -r 'print_r(getdate());'
Array
(
    [seconds] => 4
    [minutes] => 12
    [hours] => 15
    [mday] => 27
    [wday] => 1
    [mon] => 1
    [year] => 2014
    [yday] => 26
    [weekday] => Monday
    [month] => January
    [0] => 1390806724
)

?>
