<?php

// �ļ���������:

array glob ( string $pattern [, int $flags ] );      Ѱ����ģʽƥ��ļ�·�� //  ���磺("/home/s/logsrv*/data/*log*")

array  glob('*', GLOB_ONLYDIR);                      ������Ŀ¼���ļ�

string dirname(string $path)                         ����·���е�Ŀ¼����
$path = "/etc/passwd";
$file = dirname($path); // $file is set to "/etc"

string basename(string $path [, string $suffix ])    ����·���еļ�������
$path = "/home/httpd/html/index.php";
$file = basename($path);           // $file is set to "index.php"
$file = basename($path, ".php");   // $file is set to "index"

string realpath(string path);                        ���ط������ӻ����·��ת��ΪӲ���ӻ����·����

int readfile(string $filename [, bool $use_include_path = false [, resource $context ]]);    �������ݶ�ȡȡ����������ն��ϡ�(���ؼ�ʹ��)     

string tempnam(string $dir , string $prefix);        ����һ������Ψһ�����ļ���·��+����ǰ׺��

bool file_exists(string $filename)                   �жϼ�/Ŀ¼�Ƿ����;

bool is_readable(string $filename)                   �жϼ��Ƿ���Զ�

bool is_writeable(string $filename)                  �жϼ��Ƿ����д

bool mkdir(string $pathname [, int $mode [, bool $recursive [, resource $context ]]] )     �����½�һ���� pathname ָ����Ŀ¼�� 

bool copy(string $source , string $dest)             ������ source ������ dest���ɹ�ʱ���� TRUE�� ������ʧ��ʱ���� FALSE��

bool rename(string $oldname , string $newname [, resource $context ])    ��·���ƶ������԰� oldname ������Ϊ newname�� �ɹ�ʱ���� TRUE�� ������ʧ��ʱ���� FALSE��

array  file($filename)                              ���ļ����ݶ��뵽һ�������У�����ڴ������ƣ�����ini_set("memory_limit","1024m");

string file_get_contents($filename)                 �������ݶ���һ���ַ�����(�����Ǳ��ؼ���Ҳ���Է���http����ͻ�ȡhttp�������ݣ�ini_set("memory_limit","1024m");)��

int file_put_contents($filename,$data)              ������д����У�

string fgets($handle);                             һ��Ϊ��λ�Ӽ���ȡ���ݣ�feof($fp) �ж��Ƿ��ȡ������β��

string fread($handle);                             �����ư�ȫ�Ķ�

bool   unlink($filename);                          ɾ��

ʹ�þ���1:
$fp = fopen("/home/s/data/data.xml", "r");

while (!feof($fp)) {
	$line = fgets($fp);
	echo $line."\n";
}

fclose($fp);

ʹ�þ���2��
ѹ���ļ��ͷ�ѹ���ļ�ͬʱ���ڵĶ�ȡ������
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
