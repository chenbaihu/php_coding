<?php

// 文件基础函数:

array glob ( string $pattern [, int $flags ] );      寻找与模式匹配的件路径 //  例如：("/home/s/logsrv*/data/*log*")

array  glob('*', GLOB_ONLYDIR);                      查找是目录的文件

string dirname(string $path)                         返回路径中的目录部分
$path = "/etc/passwd";
$file = dirname($path); // $file is set to "/etc"

string basename(string $path [, string $suffix ])    返回路径中的件名部分
$path = "/home/httpd/html/index.php";
$file = basename($path);           // $file is set to "index.php"
$file = basename($path, ".php");   // $file is set to "index"

string realpath(string path);                        返回符号链接或相对路径转换为硬链接或绝对路径。

int readfile(string $filename [, bool $use_include_path = false [, resource $context ]]);    将件内容读取取来，输出到终端上。(下载件使用)     

string tempnam(string $dir , string $prefix);        建立一个具有唯一件名的件（路径+件名前缀）

bool file_exists(string $filename)                   判断件/目录是否存在;

bool is_readable(string $filename)                   判断件是否可以读

bool is_writeable(string $filename)                  判断件是否可以写

bool mkdir(string $pathname [, int $mode [, bool $recursive [, resource $context ]]] )     尝试新建一个由 pathname 指定的目录。 

bool copy(string $source , string $dest)             将件从 source 拷贝到 dest。成功时返回 TRUE， 或者在失败时返回 FALSE。

bool rename(string $oldname , string $newname [, resource $context ])    件路径移动，尝试把 oldname 重命名为 newname。 成功时返回 TRUE， 或者在失败时返回 FALSE。

array  file($filename)                              将文件内容读入到一个数组中；如果内存受限制，可以ini_set("memory_limit","1024m");

string file_get_contents($filename)                 将件内容读到一个字符串中(可以是本地件，也可以发送http请求和获取http请求数据，ini_set("memory_limit","1024m");)；

int file_put_contents($filename,$data)              将数据写入件中；

string fgets($handle);                             一行为单位从件读取内容；feof($fp) 判断是否读取到件结尾；

string fread($handle);                             二进制安全的读

bool   unlink($filename);                          删除

使用举例1:
$fp = fopen("/home/s/data/data.xml", "r");

while (!feof($fp)) {
	$line = fgets($fp);
	echo $line."\n";
}

fclose($fp);

使用举例2：
压缩文件和非压缩文件同时存在的读取方法：
$logfile_list = glob($logfile_pattern);
$line_count = 0;
foreach ( $logfile_list as $file )
{
    if(!file_exists($file)) continue;

    if (strlen($file) > 3 && strcasecmp(substr($file, -2), "GZ") == 0 )
    {
        $open = "gzopen";
        $read  = "gzread";
        $eof    = "gzeof";
        $close = "gzclose";
    } else {
        $open = "fopen";
        $read  = "fread";
        $eof    = "feof";
        $close = "fclose";
    }

    $fp = $open($file, "r");
    if(!$fp) continue;

    $tail = "";
    while( filesize($file) > 0 && !$eof($fp))
    {
        $str = $tail . $read($fp, READ_BUF_SIZE);
        $lines = explode("\n", $str);
        $tail = array_pop($lines);
        foreach ( $lines as $line )
        { 
            echo $line . "\n";
        }
    }
    $close($fp);
}

?>
