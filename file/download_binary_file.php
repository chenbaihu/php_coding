<?php
    header("content-type: application/x-msdownload");                 //����ָ����MIME���͵�ͷ��Ϣ
    $fileNmae = $_GET['fileName'];
    
    header("content-disposition: attachment:filename=[$fileName]");   //������������ͷ��Ϣ�������ͼ���
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
