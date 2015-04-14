<?php
    $cmd = "echo 'hello';echo 'world';echo 'this is a test'";

    $last_line_echo = system($cmd, $ret);
    if ($ret !=0 ) {
        echo("system {$cmd} failed\n");
        exit(0);
    }  
    echo("system last_line_echo={$last_line_echo} ret={$ret}\n");
    
    
    
    echo("==================================================\n");
    $last_line_echo = exec($cmd, $echo_arr, $ret);
    if ($ret != 0) {
        echo("exec {$cmd} failed\n");
        exit(0);
    }  
    echo("exec last_line_echo={$last_line_echo} ret={$ret}\n");
    echo("var_dump_echo_arr:\n");
    var_dump($echo_arr);
?>

