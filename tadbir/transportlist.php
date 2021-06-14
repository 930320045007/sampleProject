<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='81';?>
<?php

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_type = "SELECT * FROM tadbir.transport_type WHERE transporttype_status = 1 AND EXISTS (SELECT * FROM tadbir.transport WHERE transport.transporttype_id = transport_type.transporttype_id AND transport.transport_status = 1) ORDER BY transporttype_name ASC";
$type = mysql_query($query_type, $tadbirdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);

if(isset($_POST['jenis']))
	$type2 = "transport.transporttype_id='" . $_POST['jenis'] . "'";
	else if(isset($_GET['tyid']))
	$type2 = "transport.transporttype_id='" . $_GET['tyid'] . "'";
else
	$type2 = "transport.transporttype_id='1'";

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM transport WHERE ".$type2." AND transport_status = 1 ORDER BY transport_name ASC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>  
      	<div class="content">
        <?php include('../inc/menu_tadbir_user.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            	<li class="form_back">
            	  <form id="form1" name="form1" method="post" action="transportlist.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
            	      <tr>
            	        <td nowrap="nowrap" class="label noline">Jenis Kenderaan</td>
            	        <td width="100%" class="noline"><select name="jenis" id="jenis">
                          <?php
							do {  
							?>
                         <option <?php if((isset($_POST['jenis']) && $_POST['jenis']==$row_type['transporttype_id']) || (isset($_GET['tyid']) && $_GET['tyid']==$row_type['transporttype_id'])) echo "selected=\"selected\"";?> value="<?php echo $row_type['transporttype_id']?>"><?php echo $row_type['transporttype_name']?></option>
                          <?php
							} while ($row_type = mysql_fetch_assoc($type));
							  $rows = mysql_num_rows($type);
							  if($rows > 0) {
								  mysql_data_seek($type, 0);
								  $row_type = mysql_fetch_assoc($type);
							  }
							?>
                        </select>
       	                <input name="button" type="submit" class="submitbutton" id="button" value="Semak" /></td>
            	        <td align="right" valign="middle" nowrap="nowrap" class="noline"><input name="button2" type="button" class="submitbutton" id="button2" onclick="MM_goToURL('parent','transportadd.php<?php if(isset($_GET['tyid'])) echo "?tyid=" . $_GET['tyid'];?>');return document.MM_returnValue" value="Tambah" /></td>
          	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai Kenderaan Jenis <strong><?php echo getTypeNameByID($type2);?></strong></div>
 			 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_tr > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="left" valign="middle" nowrap="nowrap">Nama Kenderaan</th>
                      <th align="left" valign="middle" nowrap="nowrap"></th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><strong><a href="transportlistdetail.php?id=<?php echo $row_tr['transport_id']; ?>"><?php echo $row_tr['transport_name']; ?></a></strong>  (<?php echo $row_tr['transport_plat'];?>)</td>
                        <td align="center" valign="middle"><ul class="func"> <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                      <li><a href="transportlist_edit.php?id=<?php echo $row_tr['transport_id'];?>">Edit</a></li>
                      <?php }; ?>
                      <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                      <li><a onclick="return confirm('Anda mahu maklumat kenderaan berikut dipadam? \r\n\n <?php echo $row_tr['transport_name']; ?> (<?php echo $row_tr['transport_plat'];?>) ')" href="../sb/del_transport.php?id=<?php echo $row_tr['transport_id'];?>&tyid=<?php echo $row_tr['transporttype_id']; ?>">X</a></li>
                      <?php }; ?>
                      </ul>
                      </td>
                    </tr>
                      <?php $i++; } while ($row_tr = mysql_fetch_assoc($tr)); ?>
                     <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><ul class="func">
<li><?php echo $totalRows_tr ?> rekod dijumpai</li>
                      </ul></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
mysql_free_result($type);

mysql_free_result($tr);
?>
<?php include('../inc/footinc.php');?> 