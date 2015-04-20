<?php

$raw_post_data = file_get_contents('php://input', 'r');
echo "-------\$_POST------------------<br/>";
echo var_dump($_POST) . "<br/>";

echo "-------php://input-------------<br/>";
echo $raw_post_data . "<br/>";

?>
