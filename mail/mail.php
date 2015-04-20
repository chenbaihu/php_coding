<?php
// multiple recipients
//$to  = 'aidan@example.com' . ', '; // note the comma
$to = 'xychenbaihu@163.com';

// subject
$subject = '测试邮件标题';

// message
$message = '
<style type=\"text/css\">
table, td {
     border:1px solid #ccc;
     border-collapse:collapse;
}
</style>
<html>
<head>
<title></title>
</head>
<body>
<p>正文内容段落1!</p>
<table border=\"1\">
<tr>
<td>Person</td><td>Day</td><td>Month</td><td>Year</td>
</tr>
<tr>
<td>Joe</td><td>3rd</td><td>August</td><td>1970</td>
</tr>
<tr>
<td>Sally</td><td>17th</td><td>August</td><td>1973</td>
</tr>
</table>
</body>
</html>
';

// To send HTML mail, the Content-type header must be set
$headers  = 'MIME-Version: 1.1' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf8' . "\r\n";

// Additional headers
$headers .= 'To: xychenbaihu@163.com, xychenbaihu2@163.com' . "\r\n";
$headers .= 'From: chenbaihu@163.com' . "\r\n";
$headers .= 'Cc: billchen@163.com' . "\r\n";
$headers .= 'Bcc: billchen_sec@163.com' . "\r\n";

// Mail it
mail($to, $subject, $message, $headers);
?> 
