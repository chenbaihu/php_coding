<?php

// php正则函数：
// ereg:                    字符串比对解析。
// eregi:                   字符串比对解析，与大小写无关。
// ereg_replace:            字符串比对解析并取代。
// eregi_replace:           字符串比对解析并取代，与大小写无关。
// split:                   将字符串依指定的规则切开。
// sql_regcase:             将字符串逐字返回大小写字符。

// ereg                     字符串比对解析。    // 对应于python中的re.search，匹配到第一个就返回。
// eregi                    字符串比对解析，与大小写无关。
// 语法: int ereg(string pattern, string string, array [regs]);
// 返回值: 整数/数组
// 本函数以 pattern 的规则来解析比对字符串 string。比对结果返回的值放在数组参数 regs 之中，regs[0] 内容就是原字符串，string、regs[1] 为第一个合乎规则的字符串、regs[2] 就是第二个合乎规则的字符串，余类推。
// 若省略参数 regs，则只是单纯地比对，找到则返回值为 true。

// 测试例子：

$email = "xychenbaihu@163.com";
if (eregi("([a-z0-9A-Z]+)@([0-9a-zA-Z]+)\.([a-z]{2,3})", $email, $regs)) {  //匹配
    echo("email right\n");
    var_dump($regs);
}

$email = "xychenbaihu@163.comd";
if (eregi("([a-z0-9A-Z]+)@([0-9a-zA-Z]+)\.([a-z]{2,3})$", $email, $regs)) { //不匹配
    echo("email right\n");
    var_dump($regs);
}

//[chenbaihu@build11 ~]$ php ./tt.php
//email right
//array(4) {
//    [0]=>
//    string(19) "xychenbaihu@163.com"
//    [1]=>
//    string(11) "xychenbaihu"
//    [2]=>
//    string(3) "163"
//    [3]=>
//    string(3) "com"
//}

//ereg_replace            字符串比对解析并取代。 // 对应python中的re.sub和re.subn
//eregi_replace           字符串比对解析并取代，与大小写无关。
//语法: string ereg_replace(string pattern, string replacement, string string);
//返回值: 字符串
//        本函数以 pattern 的规则来解析比对字符串 string，欲取而代之的字符串为参数 replacement。返回值为字符串类型，为取代后的字符串结果。

$text = 'This is a {1} day, not {2} and {3}.';
$daytype = array( 1 => 'fine',
    2 => 'overcast',
    3 => 'rainy'
);
while (ereg('{([0-9]+)}', $text, $regs)) {
    $found = $regs[1];
    $text = ereg_replace("\{".$found."\}", $daytype[$found], $text);
    var_dump($regs);
}
echo "$text\n";

//[chenbaihu@build11 ~]$ php ./ttt.php
//array(2) {
//    [0]=>
//    string(3) "{1}"
//    [1]=>
//    string(1) "1"
//}
//array(2) {
//    [0]=>
//    string(3) "{2}"
//    [1]=>
//    string(1) "2"
//}
//array(2) {
//    [0]=>
//    string(3) "{3}"
//    [1]=>
//    string(1) "3"
//}
//This is a fine day, not overcast and rainy.

//split   将字符串依指定的规则切开。
//array split(string pattern, string string, int [limit]);

?>
