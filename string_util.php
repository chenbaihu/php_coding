<?php

//字符串处理：
//    ltrim                                    从字符串开始的位置删除空格或其他字符               
//                                             string ltrim(string $str [, string $charlist]);
//
//    rtrim                                    从字符串结束的位置删除空格或者其他字符               
//                                             string rtrim(string $str[, string $chirlist]);
//
//    trim                                     从字符串开始和结束的位置删除空格或者其他字符
//    
//    str_replace                              使用一个字符串( 数组)替换字符串中的另一些子串。
//
//    split                                    通过正则表达式切分字符串；
//
//    explode                                  已制定字符串切分字符串；          
//    implode                                  以指定字符串分隔符，将一个数组反转成一个字符串；
//
//    parse_ini_file  和  下面有string_to_ini  对ini格式的数据进行解析；
//
//    base64_encode   和  base64_decode        base64编解码
//
//    urlencode       和  urldecode            url格式的编解码
//
//    json_encode     和  json_decode          json编解码，在php中json数据和array数据是互通的；
//
//    $xml = simplexml_load_string($string);   将xml字符串解析为xml对象
//
//    gzcompress      和  gzuncompress         ZLIB格式压缩和解压缩
//    gzencode        和  gzdecode             GZIP格式压缩和解压缩
//    gzdeflate       和  gzinflate            DEFLATE格式压缩和解压缩

// 大小写转换：
// strtolower                        字符串转换为小写 string strtolower(string $str);
// strtoupper                        字符串转换为大写  string strtoupper(string $str); 
// ucfirst                           首字母大写 string ucfirst(string $str);
// ucwords                           将每个单词的首字母转换为大写字母 string ucwords(string $str);

//字符串大小写不敏感比较：
int strcasecmp ( string $str1 , string $str2 )             二进制安全比较字符串（不区分大小写）。
int strcmp ( string $str1 , string $str2 )                   二进制安全字符串比较（区分大小写）。

找子串：
strpos     stripos      strrpos       strripos
string strstr ( string haystack, string needle)

// replace 
//语法
//str_replace(find, replace, string, count)参数 描述
//find      必需。规定要查找的值。
//replace   必需。规定替换 find 中的值的值。
//string    必需。规定被搜索的字符串。
//count     可选。一个变量，对替换数进行计数。

// 一对一替换：
str_replace('<br>', '<p>', $Content);

// 多对一替换：
str_replace(array('<p>','</p>'), '', $Content);

// 多对多替换：
str_replace(array('<br>', '<p>','</p>'), array('<br />','<hr>',''), $Content); 

// ini
/*
commnet1="11111111111111111111111111111111111111111"
commnet2="22222222222222222222222222222222222222222"

[partent1_test]
srcfile_pattern="http://xxxxxxxxxx/data/data1.txt"
dest_file=/home/s/data/server1/data1.txt
exec_command="xxxxxx"
fail_break=false
md5_check=true

[partent2_test]
srcfile_pattern="http://xxxxxxxxxx/data/data2.txt"
dest_file=/home/s/data/server1/data2.txt
exec_command="yyyyyy"
fail_break=false
md5_check=true
*/

$ini_file_map = parse_ini_file("./config.ini", true);

function string_to_ini($ini_str_cont, $linesep = "\n", $kvsep = "=",  $process_sections = false) 
{
    $parsed_ini = array();

    $line_array = explode($linesep, trim($ini_str_cont));

    $section_name = '';
    foreach ($line_array as $line){
        $line = trim($line);

        $line_len = strlen($line);
        if ($line_len == 0) continue;

        $line_start_char = substr($line, 0, 1);
        $line_end_char   = substr($line, $line_len - 1);

        if ($line_start_char == ';' || $line_start_char == '#') {
            continue; //skip comment line
        } 
        
        switch ($line_start_char) {
            case ':':
            case '#':
                break;
            case '[':
                if ($line_end_char == ']') {
                    $section_name = substr($line, 1, $line_len - 2);
                }                         
                break;
            default;
                $kv_array = explode($kvsep, $line, 2);
                if (count($kv_array) != 2) {
                    break;
                }

                if($process_sections && strlen($section_name) != 0)
                {
                    $parsed_ini[$section_name][$kv_array[0]] = $kv_array[1];
                } else {
                    $parsed_ini[$kv_array[0]] = $kv_array[1];
                }
        }
    }                                     
    return $parsed_ini;
}


// json 
$content_json = "{"www.aaa.com":["192.168.1.1","192.168.1.2"],"www.cc.com":["192.168.1.3","192.168.1.4","192.168.1.5"],"www.bb.com":["192.168.1.6","192.168.1.7","192.168.1.8","192.168.1.9"]}";

$content_json = json_decode($content, true);
if ($content_json == "") {
    echo "json_decode $content failed\n";
    exit(1);
}
//var_dump($content_json);
foreach($content_json as $key=>$value) {
    echo "key=$key\n";
    foreach($value as $ip){
        echo "ip=$ip\n";
    }
}

$change_json = $content_json;
foreach($change_json as $key=>$value) {
    //echo "key=$key\n";
    $new_value = array();
    foreach($value as $ip) {
        //echo "ip=$ip\n";
        $new_value[] = $ip;
        $new_value[] = time();
    }
    $change_json[$key] = $new_value;
}
//var_dump($change_json);

$chang_content = json_encode($change_json);

//

?>


