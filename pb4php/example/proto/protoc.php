<?php
// just create from the proto file a pb_prot[NAME].php file
// php不支持proto里的package，所以php版编译之前先要删掉package语句

require_once('../../parser/pb_parser.php');

function ProtoPBParser($proto_file) 
{
    $proto_parser = new PBParser();
    $proto_parser->parse($proto_file);
    echo("File[$proto_file] parsing done!=======================\n");
}

$proto_arr = array(
    "../../proto/test_new.proto",
    "../../proto/test.proto",
);

foreach ($proto_arr as $k=>$v) {
    ProtoPBParser($v);
}

?>
