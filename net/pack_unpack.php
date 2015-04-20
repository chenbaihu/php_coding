<?php

//string pack ( string $format [, mixed $args [, mixed $... ]] )    // Pack data into binary string
//array  unpack ( string $format , string $data )                   // Unpack data from binary string
//int crc32 ( string $str )                                         // 生成 str 的 32 位循环冗余校验码多项式。这通常用于检查传输的数据是否完整。
//由于 PHP 的整数是带符号的，许多 crc32 校验码将返回负整数，因此你需要使用 sprintf() 或 printf() 的“%u”格式符来获取表示无符号 crc32 校验码的字符串。 


//a      NUL-padded string
//A      SPACE-padded string
//h      Hex string, low nibble first
//H      Hex string, high nibble first
//c      signed char
//C      unsigned char
//s      signed short (always 16 bit, machine byte order)                                //machine byte order           机器字节顺序
//S      unsigned short (always 16 bit, machine byte order)
//n      unsigned short (always 16 bit, big endian byte order)                           //网络字节序是大端(低字节存放高位数据)
//v      unsigned short (always 16 bit, little endian byte order)
//i      signed integer (machine dependent size and byte order)
//I      unsigned integer (machine dependent size and byte order)
//l      signed long (always 32 bit, machine byte order)
//L      unsigned long (always 32 bit, machine byte order)
//N      unsigned long (always 32 bit, big endian byte order)                            //网络字节序是大端
//V      unsigned long (always 32 bit, little endian byte order)
//f      float (machine dependent size and representation)
//d      double (machine dependent size and representation)
//x      NUL byte
//X      Back up one byte
//@      NUL-fill to absolute position 


$body    = "k1=v1&k2=v2&k3=v3&k4=v4";
$header  = "";
$header .= pack('C', 12) . pack('C', 11) . pack('n', strlen($body)) . pack('n', rand(1,1000)) . pack('C', 2) . pack('C', 1) . pack('n', 0);

$method = unpack("Cdata1/Cdata2", (substr($header, 6, 2)));   // 2 1
var_dump($method);

?>
