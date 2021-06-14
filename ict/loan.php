<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='27';?>
<?php
$wsql = "";

if(isset($_POST['userborrow_date_m']))
{
	$wsql .= " AND userborrow_date_m = '" . htmlspecialchars($_POST['userborrow_date_m'], ENT_QUOTES) . "'";
	$dm = htmlspecialchars($_POST['userborrow_date_m'], ENT_QUOTES);
} else {
	$wsql .= " AND userborrow_date_m = '" . date('m') . "'";
	$dm = date('m');
}

if(isset($_POST['userborrow_date_y']))
{
	$wsql .= " AND userborrow_date_y = '" . htmlspecialchars($_POST['userborrow_date_y'], ENT_QUOTES) . "'";
	$dy = htmlspecialchars($_POST['userborrow_date_y'], ENT_QUOTES);
} else {
	$wsql .= " AND userborrow_date_y = '" . date('Y') . "'";
	$dy = date('Y');
}
?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_loan = "SELECT * FROM ict.user_borrow WHERE userborrow_status = 1 " . $wsql . " ORDER BY userborrow_date_y DESC, userborrow_date_m DESC, userborrow_date_d DESC, userborrow_id DESC";
$loan = mysql_query($query_loan, $ictdb) or die(mysql_error());
$row_loan = mysql_fetch_assoc($loan);
$totalRows_loan = mysql_num_rows($loan);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_ict.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){ ?>
            	<li class="form_back">
            	  <form id="form1" name="form1" method="post" action="">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label noline">Tarikh</td>
            	        <td width="100%" class="noline">                          
            	        <select name="userborrow_date_m" id="userborrow_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
            	            <option <?php if($j==$dm) echo "selected=\"selected\"";?> value="<?php if($j<10) $j= "0" . $j; echo $j;?>"><?php echo $j . " - " . date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
          	            </select>
            	        <select name="userborrow_date_y" id="userborrow_date_y">
                          <?php for($k=2012; $k<=(date('Y')+1); $k++){?>
            	            <option <?php if($k==$dy) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
          	            </select>
           	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
          	        </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai pinjaman bagi bulan <strong><?php echo date('M Y', mktime(0, 0, 0, $dm, 1, $dy));?></strong></div>
  				<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_loan > 0) { // Show if recordset not empty ?>
                <tr>
                  <th align="center" valign="middle">Bil</th>
                  <th align="center" valign="middle">Tarikh</th>
                  <th width="100%" colspan="2" align="left" valign="middle">Nama / Unit</th>
                  <th nowrap="nowrap">Tempoh</th>
                  <th nowrap="nowrap">Kelulusan</th>
                  <th nowrap="nowrap">Penyerahan</th>
                </tr>
                <?php $i=1; do { ?>
                  <tr <?php if(checkICTApprovalByUserBorrowID($row_loan['userborrow_id'])==2) echo "class=\"offcourses\""; else echo "class=\"on\"";?>>
                    <td align="center" valign="middle"><?php echo $i;?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><div class="txt_line"><?php echo getDateBorrowByUserBorrowID($row_loan['userborrow_id']);?><br/><?php echo getTimeBorrowByUserBorrowID($row_loan['userborrow_id']);?></div></td>
                    <td align="center" valign="top"><?php echo viewProfilePic($row_loan['user_stafid']);?></td>
                    <td width="100%"><div class="txt_line"><div><strong><a href="loandetail.php?id=<?php echo $row_loan['userborrow_id']; ?>"><?php echo getFullNameByStafID($row_loan['user_stafid']) . " (" . $row_loan['user_stafid'] . ")"; ?></a></strong></div>
                      <div><?php echo getFulldirectoryByUserID($row_loan['user_stafid']);?><?php echo " &nbsp; &bull; &nbsp; Ext : " . getExtNoByUserID($row_loan['user_stafid']);?></div>
                      <div class="txt_color1">Tujuan : <?php echo $row_loan['userborrow_title']; ?></div>
                      <div class="txt_color1">Tempat : <?php echo $row_loan['userborrow_location']; ?></div></div></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php echo getDurationByUserBorrowID($row_loan['userborrow_id']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap"><?php iconICTApproval($row_loan['userborrow_id']);?></td>
                    <td align="center" valign="middle" nowrap="nowrap">
					<?php iconICTReturn($row_loan['userborrow_id']);?>
                    <?php if(checkICTReturnByUserBorrowID($row_loan['userborrow_id'])==0 && checkICTApprovalByUserBorrowID($row_loan['userborrow_id'])==1 && getLateReturnByUserBorrowID($row_loan['userborrow_id'])>0) echo "<div class=\"txt_size2\">" . getLateReturnByUserBorrowID($row_loan['userborrow_id']) . " Hari</div>";?>
                    </td>
                  </tr>
                  <?php $i++; } while ($row_loan = mysql_fetch_assoc($loan)); ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_loan ?> rekod dijumpai</td>
                </tr>
              <?php } else { ?>
                <tr>
                  <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                </tr>
                <?php }; ?>
              </table>
        </li>
                <?php } else { ?>
            	<li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td align="center" class="noline"><?php echo noteError(1);?></td>
                  </tr>
                </table>
				</li>
                <?php }; ?>
            </ul>
          	</div>
        </div>
</div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($loan);
?>
<?php include('../inc/footinc.php');?> 