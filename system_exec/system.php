<?php
     $downloadfile    = "{$localpath}"."{$filename}";
     $command = "wget {$midfileurl} -O{$downloadfile} -o{$downlogname} -T1000 -t3";
     $b64cmd  = base64_encode($command);
     $last_line=system("{$command}", $ret);
     if ($ret===0) {
         error_log(date("Y-m-d H:i:s")."\tDownloadMidFile\tcommand={$b64cmd}\tsucc\n" , 3, $logname);
         return true;
     }   
?>
