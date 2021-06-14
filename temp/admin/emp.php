<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='7';?>
<?php

if(isset($_POST['klas']))
	$sqlw = "AND scheme.classification_id='" . $_POST['klas'] . "'";
else if(isset($_GET['cid']))
	$sqlw = "AND scheme.classification_id='" . $_GET['cid'] . "'";
else
	$sqlw = "AND scheme.classification_id='1'";
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_klas = "SELECT * FROM classification WHERE classification_status = '1' ORDER BY classification_code ASC";
$klas = mysql_query($query_klas, $hrmsdb) or die(mysql_error());
$row_klas = mysql_fetch_assoc($klas);
$totalRows_klas = mysql_num_rows($klas);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_sch = "SELECT * FROM scheme  WHERE scheme_status = '1' " . $sqlw . " ORDER BY group_id ASC, scheme_code ASC, scheme_name ASC";
$sch = mysql_query($query_sch, $hrmsdb) or die(mysql_error());
$row_sch = mysql_fetch_assoc($sch);
$totalRows_sch = mysql_num_rows($sch);
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
        <?php include('../inc/menu_admin.php');?>
        <div class="tabbox">
          <div class="profilemenu">
          	<ul>
            	<li class="form_back">
            	  <form id="shortby" name="shortby" method="post" action="emp.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td class="label noline">Klasifikasi</td>
            	        <td width="100%" nowrap="nowrap" class="noline">
      <select name="klas" id="klas">
					<?php
            do {  
            ?>
                    <option <?php if((isset($_POST['klas']) && $_POST['klas']==$row_klas['classification_id']) || (isset($_GET['cid']) && $_GET['cid']==$row_klas['classification_id'])) echo "selected=\"selected\"";?> value="<?php echo $row_klas['classification_id']?>"><?php echo $row_klas['classification_code'] . " - " . $row_klas['classification_name'];?></option>
                    <?php
            } while ($row_klas = mysql_fetch_assoc($klas));
              $rows = mysql_num_rows($klas);
              if($rows > 0) {
                  mysql_data_seek($klas, 0);
                  $row_klas = mysql_fetch_assoc($klas);
              }
            ?>
      </select>
      <input name="button" type="submit" class="submitbutton" id="button" value="Semak" /></td>
            	        <td align="right" valign="middle" nowrap="nowrap" class="noline"><input name="button2" type="button" class="submitbutton" id="button2" onclick="MM_goToURL('parent','emp_add.php<?php if(isset($_GET['cid'])) echo "?cid=" . $_GET['cid'];?>');return document.MM_returnValue" value="Tambah" /></td>
           	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai penjawatan</div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_sch > 0) { // Show if recordset not empty ?>
    <tr>
      <th width="100%" align="left">Skim Perkhidmatan</th>
      <th nowrap="nowrap">Kod Skim</th>
      <th nowrap="nowrap">Kumpulan Perkhidmatan</th>
      <th nowrap="nowrap">&nbsp;</th>
      <th align="left" valign="middle" nowrap="nowrap">Gred</th>
      <th align="left" valign="middle">&nbsp;</th>
    </tr>
    <?php do { ?>
      <tr class="on">
        <td nowrap="nowrap"><?php echo ucwords($row_sch['scheme_name']); ?></td>
        <td align="center" nowrap="nowrap"><?php echo $row_sch['scheme_code']; ?></td>
        <td align="center" nowrap="nowrap"><?php echo getGroup($row_sch['group_id']); ?></td>
        <td align="center" nowrap="nowrap"><?php echo getClassificationAndCode2BySchemeID($row_sch['scheme_id']); ?></td>
        <td align="left" nowrap="nowrap"><?php echo $row_sch['scheme_gred']; ?></td>
        <td align="left" nowrap="nowrap">
        <ul class="func">
        	<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){ ?>
            <li><a href="emp_edit.php?id=<?php echo $row_sch['scheme_id']; ?>">Edit</a></li>
            <?php }; ?>
        	<?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){ ?>
            <li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo $row_sch['scheme_name']; ?>')" href="../sb/del_scheme.php?id=<?php echo $row_sch['scheme_id']; ?>&cid=<?php echo $row_sch['classification_id']; ?>">X</a></li>
            <?php }; ?>
        </ul>
        </td>
      </tr>
      <?php } while ($row_sch = mysql_fetch_assoc($sch)); ?>
    <tr>
      <td colspan="6" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_sch ?> rekod dijumpai</td>
      </tr>
  <?php } else { ?>
    <tr>
      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
<?php include('../inc/footinc.php');?>
<?php
mysql_free_result($klas);

mysql_free_result($sch);
?>