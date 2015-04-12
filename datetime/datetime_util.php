<?php

/////////////////
date_default_timezone_set                 //����Ĭ��ʱ�� bool date_default_timezone_set(string timezone_identifier);
date_default_timezone_get                 //��ȡĬ��ʱ�� string date_default_timezone_get(void);

����:
    date_default_timezone_set("Asia/Chongqing");

////////////////
echo time();                              //��ȡ��ǰ����


//////////////////
$date = date("Y-m-d H:i:s");
echo "date=$date\n";

echo date("Y-m-d H:i:s", time());


/////////////////
string strftime ( string $format [, int $timestamp = time() ] )    //�����ø����ĸ�ʽ�ִ��Ը����� timestamp ���и�ʽ�������ַ��������û�и���ʱ������õ�ǰ�ı���ʱ�䡣


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
//gettimeofday �� ȡ�õ�ǰʱ�䣺
chenbaihu~$php -r 'print_r(gettimeofday());'
Array
(
 [sec] => 1390806225
 [usec] => 273220
 [minuteswest] => -480
 [dsttime] => 0
 )

/////////////////
//getdate �� ȡ�����ڣ�ʱ����Ϣ��
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
