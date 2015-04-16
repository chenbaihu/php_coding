<?php

function parse_udp_host($host)
{
    $port = 53;
    $s = explode(':', $host);
    if (count($s) > 1) {
        $host = $s[0];
        $port = intval($s[1]);
    }  
    return array($host, $port);
}

function udp($host, $message)
{
    list($host, $port) = parse_udp_host($host);
    //var_dump($host, $port);
    $socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);
    socket_sendto($socket, $message, strlen($message), 0, $host, $port);
    if ($errno = socket_last_error($socket)) {
        echo socket_strerror($errno)."\n";
        return "";
    }  
    socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
    socket_recvfrom($socket, $buf, 65535, 0, $host, $port);
    if ($errno = socket_last_error($socket)) {
        echo socket_strerror($errno)."\n";
        return "";
    }  

    return substr($buf, 10);
}

?>
