<?php
    header("content-type: application/x-msdownload");                 //发送指定件MIME类型的头信息
    $fileNmae = $_GET['fileName'];
    
    header("content-disposition: attachment:filename=[$fileName]");   //发送描述件的头信息，附件和件名
    readfile($fileNmae);
?>

<?php
    $file = "images/tent.png";
    
    header("Content-Description: test png file download");
    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attchment; filename=" . basename($file));
    header("Content-Transfer-Encoding: binary");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: public");
    header("Content-Length: " . filesize($file));
    
    ob_clean();
    flush();
    
    readfile($file);
    exit();
?>
