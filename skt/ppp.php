<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='59';?>
<?php

if(isset($_GET['tahun']) && $_GET['tahun']!=0)
{
	$tahun = $_GET['tahun'];
} else {
	$tahun = date('Y');
}

mysql_select_db($database_skt, $skt);
$query_staf = "SELECT * FROM skt.pp WHERE pp_status = '1' AND pp_ppp = '" . $row_user['user_stafid'] . "' AND pp_date_y = '".$tahun. "' ORDER BY user_stafid ASC";
$staf = mysql_query($query_staf, $skt) or die(mysql_error());
$row_staf = mysql_fetch_assoc($staf);
$totalRows_staf = mysql_num_rows($staf);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../js/tabber.js"></script>
<?php include('../inc/headinc.php');?>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
        <?php include('../inc/menu.php');?>
        
      	<div class="content">
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            <?php if(checkPPPByStafID($row_user['user_stafid'])){?>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="ppp.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td nowrap class="label">Tahun</td>
                        <td width="100%">
                          <select name="tahun" id="tahun">
                        <?php for($i=date('Y'); $i>=2012; $i--){?>
                          <option value="<?php echo $i;?>" <?php if($tahun==$i) echo "selected=\"selected\"";?>><?php echo $i;?></option>
                          <?php }; ?>
                        </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai PYD bagi tahun <?php echo $tahun;?></div>
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_staf > 0) { // Show if recordset not empty ?>
                  <tr>
      <th align="left" valign="middle">Bil</th>
      <th align="left" valign="middle">Nama / Jawatan</th>
      <th align="left" valign="middle">&nbsp;</th>
      <th align="left" valign="middle">&nbsp;</th>
      </tr>
      <?php $i=1; do { ?>
      <tr class="on">
      	<td align="left" valign="middle"><?php echo $i; ?></td>
        <td class="txt_line"><strong><?php echo getFullNameByStafID($row_staf['user_stafid']); ?></strong> (<?php echo $row_staf['user_stafid'];?>)<br/>
        <span class="txt_color1">
        <div><?php echo getJobtitle($row_staf['user_stafid']); ?><br /><?php echo getFulldirectoryByUserID($row_staf['user_stafid']);?></div>
        </span></td>
        <td class="txt_line" align="center"><a href="skt.php?sid=<?php echo getID($row_staf['user_stafid']);?>">SKT</a></td>
         <td class="txt_line" align="center"><a href="staffinfo.php?lid=<?php echo $row_staf['user_stafid'];?>">LNPT</a></td>
        </tr> 
     <?php $i++; } while ($row_staf = mysql_fetch_assoc($staf)); ?>
     <tr>
                      <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_staf ?> rekod dijumpai</td>
                    </tr>
                    <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai.</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
            <?php } else { ?>
            	<li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
mysql_free_result($staf);

?>
<?php include('../inc/footinc.php');?> 