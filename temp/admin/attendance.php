<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='0';?>
<?php $menu2='0';?>
<?php 
$colname_cv = "-1";

if (isset($_GET['id'])) {
  $colname_cv = htmlspecialchars($_GET['id'], ENT_QUOTES);
}

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_cv = sprintf("SELECT * FROM courses WHERE courses_id = %s AND courses_status = '1'", GetSQLValueString($colname_cv, "int"));
$cv = mysql_query($query_cv, $hrmsdb) or die(mysql_error());
$row_cv = mysql_fetch_assoc($cv);
$totalRows_cv = mysql_num_rows($cv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/disenter.js"></script>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script language="javascript">
function checkForm(form)
{
	form.button3.disabled=true;
	form.button3.value="Proses...";
	return true;
}
</script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        
      	<div class="content">
        <div class="fl w50 content2">
            <div class="title2 padb">Pengesahan Kehadiran</div>
            <div class="txt_color1 padb">Sila isi maklumat yang diperlukan untuk pengesahan kehadiran bagi kursus berikut :</div>
            <div class="txt_line">
              <table width="100%" border="0" cellspacing="0" cellpadding="0" class="padtable">
                <tr>
                  <td colspan="2"></td>
                </tr>
                <tr>
                  <td colspan="2"><strong class="txt_size3"><?php echo getCoursesName($colname_cv);?></strong></td>
                </tr>
                <tr>
                  <td width="100" nowrap="nowrap" class="label">Tarikh</td>
                  <td>: &nbsp; <strong><?php echo getCoursesDate($colname_cv, 0);?></strong></td>
                </tr>
                <tr>
                  <td width="100" nowrap="nowrap" class="label">Tempat</td>
                  <td>: &nbsp; <?php echo getCoursesLocation($colname_cv);?></td>
                </tr>
                <tr>
                  <td nowrap="nowrap" class="label">Jam Kursus</td>
                  <td>: &nbsp; <strong><?php echo getCoursesDuration($colname_cv, $row_cv['courses_by']) . " " . getDurationType(getDurationTypeByCoursesID($colname_cv, $row_cv['courses_by']));?></strong></td>
                </tr>
              </table>
            </div>
          <div class="txt_color1 padt txt_line">Kehadiran kursus ini diluluskan oleh <?php echo getFullNameByStafID($row_user['user_stafid']) . " (" . $row_user['user_stafid'] . ")";?></div>
         </div>
         <div class="fr w50">
         <?php if(checkEndDate($row_cv['courses_id']) && checkStartDate($row_cv['courses_id'])) { ?>
         <?php if(checkUserSysAcc($row_user['user_stafid'], 5, 11, 2) && checkCoursesNeedAttendence($row_cv['courses_id'])){ ?>
         <form id="form1" name="form1" method="post" action="../sb/update_attendance.php?id=<?php echo $row_cv['courses_id']; ?>" onsubmit="return checkForm(this) && true;">
           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
             <tr>
               <td colspan="2" class="title">Daftar Masuk</td>
             </tr>
             <tr>
               <td nowrap="nowrap">Email Pengguna</td>
               <td>
               <span id="emailpengguna"><span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                 <input name="isnmail" required="required" type="text" class="user txt_right in_lower" id="isnmail" autofocus="autofocus" onkeypress="return handleEnter(this, event)"/>
               </span>
               <div class="inputlabel">@isn.gov.my</div>
               </td>
             </tr>
             <tr>
               <td nowrap="nowrap">Kata Laluan</td>
               <td>
               <input type="password" required="required" name="kt" id="kt" onkeypress="return handleEnter(this, event)"/></td>
             </tr>
             <tr>
               <td>&nbsp;</td>
               <td><input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
             </tr>
           </table>
         </form>
		 <?php } else { ?>
           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
             <tr>
               <td class="title">Daftar Masuk</td>
             </tr>
             <tr>
               <td>Pengesahan kehadiran tidak dapat dilaksanakan kerana pengguna tidak didaftarkan untuk mengaktifkannya atau kursus ini tidak memerlukan pengesahan kehadiran</td>
             </tr>
           </table>
         <?php }; } else { ?>
           <table width="100%" border="0" cellspacing="0" cellpadding="0" class="form_table">
             <tr>
               <td class="title">Daftar Masuk</td>
             </tr>
             <tr>
               <td>Pengesahan kehadiran tidak dapat dilaksanakan kerana <strong>tarikh kursus masih belum atau sudah berlansung</strong>. <br/><br/>Sila berhubung dengan <?php echo $adname; ?> untuk maklumat lanjut.</td>
             </tr>
           </table>
         <?php }; ?>
         </div>   
      </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("emailpengguna");
</script>
</body>
</html>
<?php mysql_free_result($cv); ?>
<?php include('../inc/footinc.php');?> 