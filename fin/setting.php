<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='16';?>
<?php $menu2='90';?>
<?php
mysql_select_db($database_financedb, $financedb);
$query_bil = "SELECT * FROM finance.bil WHERE bil_status = 1 ORDER BY bil_id ASC";
$bil = mysql_query($query_bil, $financedb) or die(mysql_error());
$row_bil = mysql_fetch_assoc($bil);
$totalRows_bil = mysql_num_rows($bil);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
            <div class="note">Konfigurasi untuk senarai berikut</div>
               <li class="title">Bilangan Permohonan<span class="fr add" onclick="toggleview2('bil_form'); return false;">+ Tambah</span> JKB</li>
               <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
              <div id="bil_form" class="hidden">
                <li>
                  <form id="bil_submit" name="bil_submit" method="post" action="<?php echo $url_main;?>sb/setting_finance.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline" nowrap="nowrap">Bil Permohonan</td>
                        <td nowrap="nowrap" class="noline">
                         <select name="bil_no">
                            <?php for($bn = 1; $bn<=25; $bn++){?>
                            <option <?php if($bn==1) echo "selected=\"selected\"";?> value="<?php echo $bn; ?>"><?php echo $bn; ?></option>
                            <?php }; ?>
                          </select>
                          </td>
                          <td class="label noline" nowrap="nowrap">Tarikh JKB</td>
                          <td nowrap="nowrap" class="noline">
                           <select name="bil_date_d" id="bil_date_d">
                                <?php for($i=1; $i<=31; $i++){?>
                                  <option <?php if($i==date('d')) echo "selected=\"selected\"";?> value="<?php if($i<10) $i = '0' . $i; echo $i;?>"><?php echo $i;?></option>
                                <?php }; ?>
                                </select>
                                <select name="bil_date_m" id="bil_date_m">
                                <?php for($j=1; $j<=12; $j++){?>
                                  <option <?php if($j==date('m')) echo "selected=\"selected\"";?> value="<?php if($j<10) $j = '0' . $j; echo $j;?>"><?php echo date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                                <?php }; ?>
                              </select>
                                <select name="bil_date_y" id="bil_date_y">
                                <?php for($k=date('Y'); $k<=(date('Y')+2); $k++){?>
                                  <option <?php if($k==date('Y')) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                                <?php }; ?>
                              </select>
                        <input name="button2" type="submit" class="submitbutton" id="button2" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="bil_submit" /></td>
                 </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td class="noline">
                          <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name">Bil <?php echo $row_bil['bil_no']. " &nbsp; &bull; &nbsp; " . getDateJKB($row_bil['bil_id']);?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n Bil<?php echo $row_bil['bil_no']; ?>/ <?php echo getDateJKB($row_bil['bil_id']);?>')" href="../sb/setting_finance.php?bid=<?php echo htmlspecialchars($row_bil['bil_id'], ENT_QUOTES);?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_bil = mysql_fetch_assoc($bil)); ?>
                    </ul>
                    </td>
              	    </tr>
              	  </table>
                </li>  
                <li class="gap">&nbsp;</li>
            <?php } ; ?>
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
mysql_free_result($bil);

?>
<?php include('../inc/footinc.php');?> 