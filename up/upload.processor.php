<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php
set_include_path(get_include_path() . PATH_SEPARATOR . 'phpseclib');
// include('Net/SSH2.php');
?>
<?php $menu='5';?>
<?php $menu2='5';?>
<?php $menu3 = '1';?>
<?php  

$uploadSuccess = $url_main . 'admin/profile.php?id=' . htmlspecialchars($_POST['id'], ENT_QUOTES); 
	
if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2))
{
	$img_name = stripslashes($_FILES['file']['name']);
	$img_file = $_FILES['file']['tmp_name'];
	$img_ext = strtolower(substr(strrchr($img_name, '.'), 1));
	$img_size = filesize($img_file);
	$uploadFullFilename = getStafIDByUserID(htmlspecialchars($_POST['id'], ENT_QUOTES)) . '.' . strtolower(substr(strrchr($img_name, '.'), 1)); // nama file dalam DB  
	$uploadFilename = "/var/www/html/v1/pic" . getStafIDByUserID(htmlspecialchars($_POST['id'], ENT_QUOTES)) . '.' . $img_ext;  // nama file dlm Server 
	
	//semakkan saiz
	if($img_size <= getImgSize())
	{
		//semakkan Extension
		if(($img_ext == "jpg") || ($img_ext == "jpeg") || ($img_ext == "png") || ($img_ext == "gif"))
		{
			list($width,$height)=getimagesize($img_file);
			
			//semakkan resolusi
			if($width <= getImgWidth() && $height <= getImgHeight()) 
			{
				// $connection = ssh2_connect('imas.isn.gov.my', 22);
				// ssh2_auth_password($connection, 'root', 'kJEgZNAHskmU');
				
				// $sftp = ssh2_sftp($connection);
				
				// if(checkProfilePic(getStafIDByUserID(htmlspecialchars($_POST['id'], ENT_QUOTES))))
				// {
				// 	unlink($uploadFilename);
				// }
				
				// ssh2_scp_send($connection, $_FILES['file']['tmp_name'], $uploadFilename, 0777); 

				//ni kalau local
				// move_uploaded_file($img_file, $uploadFilename);
				//ni kalau local

				// connect and login to FTP server
				$ftp_username = "root";
				$ftp_userpass = "msnict@123456";
				$ftp_server = "spsm.nsc.gov.my";
				$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
				$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

				// upload file
				if (ftp_put($ftp_conn, $uploadFilename, $img_file, FTP_BINARY))
				{
				echo "Successfully uploaded $img_file.";
				}
				else
				{
				echo "Error uploading $img_file.";
				}
				
				if(!checkProfilePic(getStafIDByUserID(htmlspecialchars($_POST['id'], ENT_QUOTES))))
				{
					$insertSQL = sprintf("INSERT INTO www.user_pic (user_stafid, userpic_url) VALUES (%s, %s)",
										 GetSQLValueString(getStafIDByUserID(htmlspecialchars($_POST['id'], ENT_QUOTES)), "text"),
										 GetSQLValueString($uploadFullFilename, "text"));
				  
					mysql_select_db($database_hrmsdb, $hrmsdb);
					$Result1 = mysql_query($insertSQL, $hrmsdb) or die(mysql_error());
				} 
				
				$uploadSuccess .= "&msg=edit";
				
				// ssh2_exec($connection, 'exit'); 

				// close connection
				ftp_close($ftp_conn);
				
			} else {
				$uploadSuccess .= "&eup=3";
			};
			
		} else {
			$uploadSuccess .= "&eup=2";
		};
				
	} else {
		$uploadSuccess .= "&eup=1";
	};
	
} else {
	$uploadSuccess .= "&msg=error";
}; // Access Level

header(sprintf("Location: %s", $uploadSuccess));  

?>
