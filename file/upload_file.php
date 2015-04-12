<?php

//1、客户端设置：
//（1）、在标签中将enctype和method两个属性指明相应的值。 Enctype="multipart/form-data"; Method="POST"
//（2）、form表单中设置一个hidden类型的input框，其中name的值为MAX_FILE_SIZE的隐藏值

//2、服务器端设置：
//（1）、$_FILES多维数组：用于存储各种上传件有关的信息
//（2）、件上传与php配置件的设置，如以下php.ini件中的一些指令（配置件的路径为：/usr/local/php5/lib/php.ini）
//指令              默认值     功能描述
//file_uploads      ON         确定服务器上的PHP脚本是否可以接受HTTP件上传
//memory_limit      8M         设置脚本可以分配的最大内存量，防止失控的脚本独占服务器内存
//upload_max_file   2M         限制PHP处理上传件大小的最大值，此值必须小于POST_MAX_SIZE值
//post_max_size     8M         限制通过POST方法可以接受信息的最大值
//upload_tmp_dir    NULL       上传件的临时路径，可以是一个绝对路径

//3、PHP的文件上传及资源指令           (可以在代码中修改指令属性，即，可以在运行时修改php的配置信息)
//file_uploads(boolean)                是否开启HTTP POST文件上传功能
//max_execution_time(integer)          PHP脚本最长执行时间
//memory_limit(integer)                单位M PHP脚本运行的最大内存
//upload_max_filesize(integer)         单位M PHP上传文件的最大尺寸
//upload_tmp_dir(string)               上传文件存储的临时位置
//post_max_size(integer)               单位M HTTP POST数据的最大尺寸

4、$_FILES数组
//$_FILES['userfile']['size']        获取上传文件的字节数
//$_FILES['userfile']['type']        获取上传文件的MIME类型，每种MIME类型都是由“/”分隔的主类型和子类型组成
//$_FILES['userfile']['error']       获取上传文件的错误代码，
//                                       0：无任何错误，文件上传成功；
//                                       1：上传文件大小超出了PHP配置文件中upload_max_filesize选项限定的值；
//                                       2：上传文件大小超出了HTML表单中MAX_FILE_SIZE指定的值；
//                                       3：表示文件只被部分上传；
//                                       4：表示没有上传任何文件。
//
//$_FILES['userfile']['name']        获取上传文件的原始名称，包含扩展名
//$_FILES['userfile']['tmp_name']    获取上传文件的临时位置名称，这是存储在临时目录中所指定的文件名。

//5、文件上传函数
//is_upload_file                     判断指定的文件是否是通过HTTP POST上传    bool is_upload_file(string $filename)
//move_upload_file                   将上传文件移至新位置     bool move_upload_file(string $filename, string $destination)
                                     注意：文件上传后，首先会存储于服务器的临时目录中，可以使用该函数将上传文件移动到新位置，
                                          与copy()和move()相比，它能检测并确保第一个参数filename指定的文件是否是合法上传的文件

//6、错误信息描述
//UPLOAD_ERR_OK{value=0}
//UPLOAD_ERR_INI_SIZE{value=1}
//UPLOAD_ERR_FORM_SIZE{value=2}
//UPLOAD_ERR_PARTIAL{value=3}
//UPLOAD_ERR_NO_FILE{value=4}
//UPLOAD_ERR_NO_TMP_DIR{value=6}
//UPLOAD_ERR_CANT_WRITE{value=7}

?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>文件上传测试0.1</title>
<link rel="stylesheet" href="style.css" type="text/css">
</head>
<script language="javascript"> 
    function checkreg()
    { 		 
        if (form1.data_file.value=="" )
		{
	        alert("data file can't empty!");
			form1.mid_file.focus();
			return false;
	    }
		return true;
    }	
</script>

<?php 
if($_POST['submit']){
    // 取得网页的参数
    $data_file      = $_FILES['data_file']['name'];      // 被上传文件的名称
    $data_filetype  = $_FILES['data_file']['type'];      // 被上传文件的类型
    $data_filesize  = $_FILES['data_file']['size'];      // 被上传文件的大小，以字节计
    $data_fileerror = $_FILES['data_file']['error'];     // 由文件上传导致的错误代码
    $data_filetmp   = $_FILES['data_file']['tmp_name'];  // 存储在服务器的文件的临时副本的名称
    echo("data_file={$data_file}\tdata_filetmp={$data_filetmp}\tdata_filetype={$data_filetype}\tdata_filesize={$data_filesize}\tdata_fileerror={$data_fileerror}\n");

    if (file_exists("upload/".$data_file)) {
        echo $data_file."already exists";
    } else {
        move_uploaded_file($_FILES['data_file']['tmp_name'],"/usr/local/apache2/htdocs/t/upload_file/a.txt");
    }
	
    $ret = true;
    if ($ret == false) {
        echo "<script language=javascript>alert('文件上传失败');</script>";
    } else {
        echo "<script language=javascript>alert('文件上传成功'.'data_file='.$data_file.'data_filetmp='.$data_filetmp.);</script>";
    }
}
?>

<body>
<form name="form1" method="post" action="" enctype='multipart/form-data' onSubmit="return checkreg()" >
  <table width="782" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
    <tr> 
      <th colspan="2" bgcolor="#FFFFFF"><font size="5">文件上传测试页面</font></th>
    </tr>    
    <tr> 
      <td align="right" bgcolor="#FFFFFF">file：</td>
      <td bgcolor="#FFFFFF"> 
        <input type="file" name="data_file" value="数据文件">        
    </tr>   
    <tr> 
      <td align=right bgcolor="#FFFFFF"> 
        <input type="reset" name="submit" value="重 写">
      </td>     
      <td  align=left bgcolor="#FFFFFF" > 
        <input type="submit" name="submit" value="提 交">
      </td>
    </tr>
  </table>
</form>
</body>

</html>
