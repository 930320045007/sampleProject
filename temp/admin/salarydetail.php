<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='5';?>
<?php $menu2='34';?>
<?php
$colname_us = "-1";
if (isset($_GET['id'])) {
  $colname_us = getID($_GET['id'],0);
}
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_us = sprintf("SELECT * FROM user_salary WHERE user_stafid = %s AND usersalary_id = %s ORDER BY usersalary_id DESC", GetSQLValueString($colname_us, "text"), GetSQLValueString($_GET['tid'], "int"));
$us = mysql_query($query_us, $hrmsdb) or die(mysql_error());
$row_us = mysql_fetch_assoc($us);
$totalRows_us = mysql_num_rows($us);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_trans = "SELECT * FROM `transaction` WHERE transactiontype_id = '" . getTransactionTypeID($row_us['transaction_id']) . "' ORDER BY transaction_name ASC";
$trans = mysql_query($query_trans, $hrmsdb) or die(mysql_error());
$row_trans = mysql_fetch_assoc($trans);
$totalRows_trans = mysql_num_rows($trans);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_tt = "SELECT * FROM transaction_type WHERE transactiontype_status = 1 ORDER BY transactiontype_id ASC";
$tt = mysql_query($query_tt, $hrmsdb) or die(mysql_error());
$row_tt = mysql_fetch_assoc($tt);
$totalRows_tt = mysql_num_rows($tt);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kewelist = "SELECT user_kewe.* FROM www.user_kewe WHERE userkewe_status = 1 AND user_kewe.user_stafid = '" . $colname_us . "' AND NOT EXISTS (SELECT * FROM www.user_salary WHERE user_stafid ='" . $colname_us . "' AND user_salary.usersalary_kew8 = user_kewe.userkewe_id)";
$kewelist = mysql_query($query_kewelist, $hrmsdb) or die(mysql_error());
$row_kewelist = mysql_fetch_assoc($kewelist);
$totalRows_kewelist = mysql_num_rows($kewelist);
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2) && $row_user['user_stafid']!=$colname_us){?>
                <li>
                <div class="note">Kemaskini maklumat pemotongan</div>
                  <table width="100%" border="0" cellpadding="0" cellspacing="0" class="icon_table">
                    <tr>
                      <td><?php echo viewProfilePic($colname_us);?></td>
                      <td width="100%" class="txt_line">
                          <div><strong><?php echo getFullNameByStafID($colname_us) . " (" . $colname_us . ")";?></strong></div>
                          <div><?php echo getFulldirectoryByUserID($colname_us);?></div>
                      </td>
                    </tr>
                  </table>
                  <form id="form2" name="form2" method="POST" action="../sb/update_usersalary.php?bulan=<?php echo $_GET['bulan'];?>">
                  <?php echo getPassBoxF('formPasswordc', 'Pengesahan kata laluan diperlukan untuk tindakan selanjutnya.');?>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap="nowrap" class="label noline">Tarikh Mula *</td>
                        <td width="50%" class="noline">
                        <div>
                          <select name="usersalary_date_d" id="usersalary_date_d">
                          <?php for($i=1; $i<=31; $i++){?>
                            <option <?php if($row_us['usersalary_date_d']==$i) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                          </select>
                          <select name="usersalary_date_m" id="usersalary_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
                            <option <?php if($j==$row_us['usersalary_date_m']) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('m - M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
                        </select>
                          <select name="usersalary_date_y" id="usersalary_date_y">
                          <?php $year = (date('Y')+5); for($k=(date('Y')-5); $k<$year; $k++){?>
                            <option <?php if($k==$row_us['usersalary_date_y']) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
                        </select>
                        </div>
                        </td>
                        <td nowrap="nowrap" class="label noline">Tarikh Tamat *</td>
                        <td width="50%" class="noline">
                        <div>
                          <select name="usersalary_end_d" id="usersalary_end_d">
                            <option selected="selected" value="0">0</option>
                          <?php for($l=1; $l<=31; $l++){?>
                            <option <?php if($row_us['usersalary_end_d']==$l) echo "selected=\"selected\"";?> value="<?php if($l<10) $l = '0' . $l; echo $l;?>"><?php echo $l;?></option>
                          <?php }; ?>
                          </select>
                          <select name="usersalary_end_m" id="usersalary_end_m">
                            <option selected="selected" value="0">0</option>
                          <?php for($m=1; $m<=12; $m++){?>
                            <option <?php if($row_us['usersalary_end_m']==$m) echo "selected=\"selected\"";?> value="<?php if($m<10) $m = '0' . $m; echo $m;?>"><?php echo date('m - M', mktime(0, 0, 0, $m, 1, date('Y')));?></option>
                          <?php }; ?>
                        </select>
                          <select name="usersalary_end_y" id="usersalary_end_y">
                            <option selected="selected" value="0">0</option>
                          <?php for($n=(date('Y')-2); $n<=$year; $n++){?>
                            <option  <?php if($row_us['usersalary_end_y']==$n) echo "selected=\"selected\"";?> value="<?php echo $n;?>"><?php echo $n;?></option>
                          <?php }; ?>
                        </select>
                        </div>
                        <div class="inputlabel2">0 untuk Berterusan</div></td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">Kategori</td>
                        <td width="50%" class="noline">
                          <select name="tt" id="tt" onChange="dochange('10', 'transaction_id', this.value, '0');">
                            <option value="0" <?php if (!(strcmp(0, $row_us['transaction_id']))) {echo "selected=\"selected\"";} ?>>Sila pilih Kategori</option>
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_tt['transactiontype_id']?>" <?php if (!(strcmp($row_tt['transactiontype_id'], getTransactionTypeID($row_us['transaction_id'])))) {echo "selected=\"selected\"";} ?>><?php echo $row_tt['transactiontype_name']?></option>
							<?php
                            } while ($row_tt = mysql_fetch_assoc($tt));
                              $rows = mysql_num_rows($tt);
                              if($rows > 0) {
                                  mysql_data_seek($tt, 0);
                                  $row_tt = mysql_fetch_assoc($tt);
                              }
                            ?>
                          </select>
                          <select name="transaction_id" id="transaction_id">
                            <option value="0" <?php if (!(strcmp(0, $row_us['transaction_id']))) {echo "selected=\"selected\"";} ?>>Sila pilih Kategori</option>
                            <?php
do {  
?>
                            <option value="<?php echo $row_trans['transaction_id']?>"<?php if (!(strcmp($row_trans['transaction_id'], $row_us['transaction_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_trans['transaction_name']?></option>
                            <?php
} while ($row_trans = mysql_fetch_assoc($trans));
  $rows = mysql_num_rows($trans);
  if($rows > 0) {
      mysql_data_seek($trans, 0);
	  $row_trans = mysql_fetch_assoc($trans);
  }
?>
                          </select>
                        </td>
                        <td nowrap="nowrap" class="label noline">Rujukan Kew8</td>
                        <td width="50%" class="noline">
                          <select name="usersalary_kew8" id="usersalary_kew8">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_kewelist['userkewe_id']?>" <?php if (!(strcmp($row_kewelist['userkewe_id'], $row_us['usersalary_kew8']))) {echo "selected=\"selected\"";} ?>><?php echo $row_kewelist['userkewe_date_m'] . "/" . $row_kewelist['userkewe_date_y'] . "/" . $row_kewelist['userkewe_siri']?> <?php echo getKew8NameByID($row_kewelist['kewe_id']);?></option>
                            <?php
							} while ($row_kewelist = mysql_fetch_assoc($kewelist));
							  $rows = mysql_num_rows($kewelist);
							  if($rows > 0) {
								  mysql_data_seek($kewelist, 0);
								  $row_kewelist = mysql_fetch_assoc($kewelist);
							  }
							?>
                            <option value="0" <?php if (!(strcmp(0, $row_us['usersalary_kew8']))) {echo "selected=\"selected\"";} ?>>Tiada</option>
                          </select>
                        </td>
                      </tr>
                      <tr>
                        <td nowrap="nowrap" class="label noline">Jumlah</td>
                        <td width="50%" class="noline"><span class="inputlabel">RM</span> <input name="usersalary_value" type="text" class="w50" id="usersalary_value" value="<?php echo $row_us['usersalary_value']; ?>" /><div class="inputlabel2">Cth : 200.00</div></td>
                        <td nowrap="nowrap" class="label noline">Rujukan</td>
                        <td width="50%" nowrap="nowrap" class="noline"><label for="usersalary_ref"></label>
                        <input name="usersalary_ref" type="text" id="usersalary_ref" value="<?php echo $row_us['usersalary_ref']; ?>" /></td>
                      </tr>
                      <tr>
                        <td class="label noline">
                        <input name="usersalary_id" type="hidden" id="usersalary_id" value="<?php echo $row_us['usersalary_id']; ?>" />                          <input name="user_stafid" type="hidden" id="user_stafid" value="<?php echo $row_us['user_stafid']; ?>" />
                        </td>
                        <td colspan="3" class="noline">
                        <input name="button4" type="button" class="submitbutton" id="button4" value="Kemaskini" onClick="toggleview2('formPasswordc'); return false;" />
                        <input name="button5" type="button" class="cancelbutton" id="button5" value="Batal" onclick="MM_goToURL('parent','salary.php?id=<?php echo getID($row_us['user_stafid'],1);?>&bulan=<?php echo $_GET['bulan'];?>');return document.MM_returnValue" />
                    	<input type="hidden" name="MM_update" value="form2" />
                    	</td>
                      </tr>
                    </table>
                  </form>
                </li>
            <?php } else { ?>
            <li>
           	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	  <tr>
            	    <td class="noline"><?php echo noteError();?></td>
          	    </tr>
          	  </table>
            </li>
            <?php }; ?>
            </ul>
            </div>
        </div>
        <span class="inputlabel2 padt fl">* perubahan pada tarikh akan memberi kesan kepada penyata gaji sebelumnya</span>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($us);

mysql_free_result($trans);

mysql_free_result($tt);

mysql_free_result($kewelist);
?>
<?php include('../inc/footinc.php');?>
