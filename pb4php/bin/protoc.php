<?php
// just create from the proto file a pb_prot[NAME].php file
require_once(dirname(__FILE__) . '/parser/pb_parser.php');

$test = new PBParser();
$test->parse($argv[1]);

var_dump('File parsing done!');
?>
