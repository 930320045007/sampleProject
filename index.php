<?php //echo phpinfo();?>

<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/func.php');?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}
  $MM_redirectLoginSuccess = "main.php";
  $MM_redirectLoginFailed = "index.php?e=login";

if (isset($_POST['pengguna']) && $_POST['pengguna']!=NULL) {
  $loginUsername = $_POST['pengguna'] . "@nsc.gov.my";              
  $password = getPassKey($_POST['katalaluan'],'1');
  $MM_fldUserAuthorization = "";
  $MM_redirecttoReferrer = false;
  mysql_select_db($database_hrmsdb, $hrmsdb);
  
  $LoginRS__query=sprintf("SELECT login_username, login_password, user_stafid FROM login WHERE login_username=%s AND login_password=%s AND login_status='1'",
    GetSQLValueString($loginUsername, "login"), GetSQLValueString($password, "login")); 
   
  $LoginRS = mysql_query($LoginRS__query, $hrmsdb) or die(mysql_error());
  $row_user = mysql_fetch_assoc($LoginRS);
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	
	$_SESSION['user_stafid'] = $row_user['user_stafid'];	

    if (isset($_SESSION['PrevUrl']) && false) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
	
	sys_prolog($_SESSION['user_stafid'], 1);
	
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}

?>
<?php $menu='0';?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
<script type="text/javascript" src="js/disenter.js"></script>
<script language="javascript">
function checkForm(form)
{
	form.button.disabled=true;
	form.button.value="Proses...";
	return true;
}
</script>
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('inc/header.php');?>
        
      	<div class="content">
        <div class="fl w50 content2">
        <div class="title2">Pengenalan</div><br/>
        <ul>
        	<li class="txt_line">Sistem ini dibangunkan untuk Kakitangan Majlis Sukan Negara Malaysia yang berdaftar melalui Cawangan Sumber Manusia sahaja.</li>
        	<li class="txt_line">Bahagian Khidmat Pengurusan bertanggungjawab terhadap pengurusan dan kemaskini  kandungan dalam sistem mengikut modul yang ditetapkan.</li>
        	<li class="txt_line">Sistem ini masih dalam proses pembangunan (versi Beta), maklum balas amat digalakkan.</li>
        </ul>
        </div>
        <div class="fr w50">
      	  <form id="login" name="login" method="POST" action="<?php echo $loginFormAction; ?>" onsubmit="return checkForm(this) && true;">
      	    <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="form_table">
      	      <tr>
      	        <td colspan="2" class="title">Pendaftaran Masuk</td>
   	          </tr>
      	      <tr>
      	        <td nowrap="nowrap">Email Pengguna</td>
      	        <td>
   	            <input class="user txt_right" autofocus="autofocus" required="required" type="text" name="pengguna" id="pengguna" onkeypress="return handleEnter(this, event)"/> 
   	            <span class="inputlabel">@nsc.gov.my</span></td>
   	          </tr>
      	      <tr>
      	        <td nowrap="nowrap">Kata Laluan</td>
      	        <td><input class="pass" type="password" required="required" name="katalaluan" id="katalaluan" onkeypress="return handleEnter(this, event)" /></td>
   	          </tr>
      	      <tr>
      	        <td>&nbsp;</td>
      	        <td><input name="button" type="submit" class="submitbutton" id="button" value="Log Masuk" /></td>
   	          </tr>
      	      <tr>
      	        <td class="noline">&nbsp;</td>
      	        <td class="noline"><a href="fail.php">Lupa Kata Laluan?</a></td>
   	          </tr>
   	        </table>
   	      </form>
          </div>
        </div>
        
		<?php include('inc/footer.php');?>
  </div>
</div>
</body>
</html>
<?php include('inc/footinc.php');?>