<?php

function tcp($address, $port, $req)
{
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if($socket < 0) {
        echo "socket_create failed  reason:".socket_strerror($socket)."\n";        //其中.是字符串连接
        exit;
    }

    $result = socket_connect($socket, $address, $port);
    if($result < 0) {
        echo "socket_connect failed  reason:".socket_strerror($result)."\n";
        socket_close($socket);
        return $result;
    }

    $ans    = "";
    $result = "";

    socket_write($socket, $req, strlen($req));

    while($ans = socket_read($socket, 4096)) {
        $result .= $ans;
    }

    socket_close($socket);
    return $result;
}  

?>

