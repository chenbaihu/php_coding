<?php

//�ַ�������
//    ltrim                                    ���ַ�����ʼ��λ��ɾ���ո�������ַ�               
//                                             string ltrim(string $str [, string $charlist]);
//
//    rtrim                                    ���ַ���������λ��ɾ���ո���������ַ�               
//                                             string rtrim(string $str[, string $chirlist]);
//
//    trim                                     ���ַ�����ʼ�ͽ�����λ��ɾ���ո���������ַ�
//    
//    str_replace                              ʹ��һ���ַ���( ����)�滻�ַ����е���һЩ�Ӵ���
//
//    split                                    ͨ��������ʽ�з��ַ�����
//
//    explode                                  ���ƶ��ַ����з��ַ�����          
//    implode                                  ��ָ���ַ����ָ�������һ�����鷴ת��һ���ַ�����
//
//    parse_ini_file  ��  ������string_to_ini  ��ini��ʽ�����ݽ��н�����
//
//    base64_encode   ��  base64_decode        base64�����
//
//    urlencode       ��  urldecode            url��ʽ�ı����
//
//    json_encode     ��  json_decode          json����룬��php��json���ݺ�array�����ǻ�ͨ�ģ�
//
//    $xml = simplexml_load_string($string);   ��xml�ַ�������Ϊxml����
//
//    gzcompress      ��  gzuncompress         ZLIB��ʽѹ���ͽ�ѹ��
//    gzencode        ��  gzdecode             GZIP��ʽѹ���ͽ�ѹ��
//    gzdeflate       ��  gzinflate            DEFLATE��ʽѹ���ͽ�ѹ��

// ��Сдת����
// strtolower                        �ַ���ת��ΪСд string strtolower(string $str);
// strtoupper                        �ַ���ת��Ϊ��д  string strtoupper(string $str); 
// ucfirst                           ����ĸ��д string ucfirst(string $str);
// ucwords                           ��ÿ�����ʵ�����ĸת��Ϊ��д��ĸ string ucwords(string $str);

//�ַ�����Сд�����бȽϣ�
int strcasecmp ( string $str1 , string $str2 )             �����ư�ȫ�Ƚ��ַ����������ִ�Сд����
int strcmp ( string $str1 , string $str2 )                   �����ư�ȫ�ַ����Ƚϣ����ִ�Сд����

���Ӵ���
strpos     stripos      strrpos       strripos
string strstr ( string haystack, string needle)

// replace 
//�﷨
//str_replace(find, replace, string, count)���� ����
//find      ���衣�涨Ҫ���ҵ�ֵ��
//replace   ���衣�涨�滻 find �е�ֵ��ֵ��
//string    ���衣�涨���������ַ�����
//count     ��ѡ��һ�����������滻�����м�����

// һ��һ�滻��
str_replace('<br>', '<p>', $Content);

// ���һ�滻��
str_replace(array('<p>','</p>'), '', $Content);

// ��Զ��滻��
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


