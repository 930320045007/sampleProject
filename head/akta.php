<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/aktadb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/aktafunc.php');?>
<?php $menu='14';?>
<?php $menu2='47';?>
<?php
mysql_select_db($database_aktadb, $aktadb);
$query_cat = "SELECT * FROM akta.category WHERE category_status = 1 ORDER BY category_name ASC";
$cat = mysql_query($query_cat, $aktadb) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);

$wsql2 = "";
$catap = 0;
$yearap = 0;

if(isset($_POST['category_id']) && $_POST['category_id']!=0)
{
	$wsql2 .= " AND category_id='" . $_POST['category_id'] . "'";
	$catap = $_POST['category_id'];
}

if(isset($_POST['ap_year']) && $_POST['ap_year']!=0)
{
	$wsql2 .= " AND ap_year='" . $_POST['ap_year'] . "'";
	$yearap = $_POST['ap_year'];
}

mysql_select_db($database_aktadb, $aktadb);
$query_akpe = "SELECT * FROM akta.ap WHERE ap_status = 1 " . $wsql2 . " ORDER BY ap_year DESC, ap_date_y DESC, ap_date_m DESC, ap_date_d+0 DESC, ap_id DESC";
$akpe = mysql_query($query_akpe, $aktadb) or die(mysql_error());
$row_akpe = mysql_fetch_assoc($akpe);
$totalRows_akpe = mysql_num_rows($akpe);

mysql_select_db($database_aktadb, $aktadb);
$query_y = "SELECT ap_year FROM akta.ap WHERE ap_status = 1 GROUP BY ap_year ORDER BY ap_year DESC";
$y = mysql_query($query_y, $aktadb) or die(mysql_error());
$row_y = mysql_fetch_assoc($y);
$totalRows_y = mysql_num_rows($y);
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
        <?php include('../inc/menu_qna.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            	<li class="form_back">
                    <form id="form1" name="form1" method="post" action="akta.php">
                      <table width="100" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td align="left" valign="middle" nowrap="nowrap" class="label">Kategori / Tahun</td>
                          <td width="100%" align="left" valign="middle">
                          <select name="category_id" id="category_id">
                            <option <?php if($catap==0) echo "selected=\"selected\"";?> value="0">Semua</option>
                            <?php
							do {  
							?>
                            <option <?php if($catap==$row_cat['category_id']) echo "selected=\"selected\"";?> value="<?php echo $row_cat['category_id']?>"><?php echo $row_cat['category_name']?></option>
                            <?php
							} while ($row_cat = mysql_fetch_assoc($cat));
							  $rows = mysql_num_rows($cat);
							  if($rows > 0) {
								  mysql_data_seek($cat, 0);
								  $row_cat = mysql_fetch_assoc($cat);
							  }
							?>
                          </select>
                            <select name="ap_year" id="ap_year">
                            	<option <?php if($yearap==0) echo "selected=\"selected\"";?> value="0">Semua</option>
                            	<?php do { ?>
                                <option value="<?php echo $row_y['ap_year']; ?>"><?php echo $row_y['ap_year']; ?></option>
                              	<?php } while ($row_y = mysql_fetch_assoc($y)); ?>
                            </select>
                          <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                          <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                          <td align="left" valign="middle"><input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onclick="MM_goToURL('parent','aktaadd.php');return document.MM_returnValue" /></td>
                          <?php }; ?>
                        </tr>
                      </table>
                    </form>
                  </li>
                <li>
                <div class="note">Senarai Akta dan Pekeliling <?php if($catap!=0) echo " > " . getCategoryName($catap);?></div>
                      <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_akpe > 0) { // Show if recordset not empty ?>
                        <tr>
                          <th nowrap="nowrap">Bil</th>
                          <th width="80%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                          <th width="20%" colspan="3" align="center" valign="middle" nowrap="nowrap">Pautan</th>
                        </tr>
                        <?php $i=1; do { ?>
                          <tr class="on">
                            <td><?php echo $i;?></td>
                            <td align="left" valign="middle">
                              <div class="padb"><?php if($row_akpe['apsumberurl']!=NULL){?><a href="<?php echo $row_akpe['apsumberurl']; ?>" target="_blank"><strong><?php echo $row_akpe['ap_title']; ?></strong></a><?php }; ?></div>
                              <div class="padb txt_color1"><?php echo $row_akpe['ap_note']; ?></div>
                          <div class="txt_color1">Sumber : <?php echo $row_akpe['ap_sumber']; ?> &nbsp; &bull; &nbsp; Tahun : <?php echo $row_akpe['ap_year']; ?></div>
                              </td>
                            <td width="10%" align="center" valign="middle"><?php if($row_akpe['ap_file']!=NULL){?><a href="<?php echo $row_akpe['ap_file']; ?>" target="_blank"><img src="../icon/mimepdf.png" width="16" height="16" alt="PDF" /></a><?php }; ?></td>
                            <td width="10%" align="center" valign="middle"><?php if($row_akpe['apsumberurl']!=NULL){?><a href="<?php echo $row_akpe['apsumberurl']; ?>" target="_blank"><img src="../icon/link.png" width="16" height="16" /></a><?php }; ?></td>
                            <td align="center" valign="middle" nowrap="nowrap">
							<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                            <ul class="func"><li><a href="aktaedit.php?id=<?php echo $row_akpe['ap_id']; ?>">Edit</a></li><?php }; ?>
							<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                            <li><a onclick="return confirm('Anda mahu Akta / Pekeliling berikut dipadam? \r\n\n <?php echo $row_akpe['ap_title']; ?> Tahun <?php echo $row_akpe['ap_year']; ?>')" href="../sb/del_akta.php?id=<?php echo $row_akpe['ap_id']; ?>">X</a></li></ul><?php }; ?></td>
                          </tr>
                        <?php $i++; } while ($row_akpe = mysql_fetch_assoc($akpe)); ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_akpe ?> rekod dijumpai</td>
                        </tr>
                        <?php } else { ?>
                        <tr>
                          <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                        </tr>
                        <?php }; ?>
                      </table>
                </li>
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
mysql_free_result($cat);

mysql_free_result($akpe);

mysql_free_result($y);
?>
<?php include('../inc/footinc.php');?> 