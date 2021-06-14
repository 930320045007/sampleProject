<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='31';?>
<?php
if(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'],ENT_QUOTES);
else
	$y = date('Y');
	
mysql_select_db($database_ictdb, $ictdb);
$query_jen = "SELECT * FROM ict.service_type WHERE servicetype_status = 1 AND EXISTS (SELECT * FROM ict.service WHERE service.servicetype_id = service_type.servicetype_id AND service.service_status = 1) ORDER BY servicetype_name ASC";
$jen = mysql_query($query_jen, $ictdb) or die(mysql_error());
$row_jen = mysql_fetch_assoc($jen);
$totalRows_jen = mysql_num_rows($jen);

if(isset($_GET['jenis']))
	$jenis = " AND servicetype_id = '" . htmlspecialchars($_GET['jenis'], ENT_QUOTES) . "' ";
else
	$jenis = "";

mysql_select_db($database_ictdb, $ictdb);
$query_service = "SELECT * FROM ict.service WHERE service_status = 1 " . $jenis . "  AND service_date_y= '".$y."' ORDER BY service_id DESC";
$service = mysql_query($query_service, $ictdb) or die(mysql_error());
$row_service = mysql_fetch_assoc($service);
$totalRows_service = mysql_num_rows($service);

mysql_select_db($database_ictdb, $ictdb);
$query_type = "SELECT * FROM service_type WHERE servicetype_status = 1 ORDER BY servicetype_name ASC";
$type = mysql_query($query_type, $ictdb) or die(mysql_error());
$row_type = mysql_fetch_assoc($type);
$totalRows_type = mysql_num_rows($type);
	
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
            <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 1)){?>
            <li class="form_back">
              <form id="form1" name="form1" method="get" action="servicelist.php">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="label">Jenis</td>
                	        <td width="100%" align="left" valign="middle" class="noline">
                	            <select name="jenis" id="jenis">
                                 <option value="0">Pilih Jenis</option>
                          <?php
							do {  
							?>
                          <option <?php if(isset($_GET['jenis']) && $_GET['jenis']==$row_jen['servicetype_id']) echo "selected=\"selected\"";?> value="<?php echo $row_jen['servicetype_id']?>"><?php echo $row_jen['servicetype_name']?></option>
                          <?php
							} while ($row_jen= mysql_fetch_assoc($jen));
							?>
                        </select>
                         <span class="inputlabel"> &nbsp; <b>Tahun</b></span>
                          <select name="y" id="y">
                          <?php for($i=2013; $i<=date('Y'); $i++){?>
                            <option <?php if($i == $y) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                          </select>
                           <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                    <td class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onClick="MM_goToURL('parent','serviceadd.php');return document.MM_returnValue"/></td>
                  </tr>
                </table>
              </form>
            </li>
            	<li>
            	  <div class="note">Senarai Perkhidmatan <strong> <?php if(isset($_GET['jenis'])) echo "<strong>" . getServiceTypeByID($_GET['jenis']) . "</strong>"; ?></strong></div></li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_service > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="center" valign="middle" nowrap="nowrap">Tarikh</th>
                       <th width="100%" align="left" valign="middle" nowrap="nowrap">Perkara</th>
                      <th align="center" valign="middle" nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                  	<tr class="<?php if(checkEndDateService($row_service['service_id'])) echo "on"; else echo "offcourses";?>">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo getServiceDateByID($row_service['service_id']);?></td> 
                   	  <td align="left" valign="middle" class="txt_line">
                        <a href="servicedetail.php?id=<?php echo getID(htmlspecialchars($row_service['service_id'],ENT_QUOTES)); ?>">
                        <div><strong><?php echo getServiceTitleByID($row_service['service_id']); ?></strong></div>
                        </a>
                         <div class="txt_color1">Oleh : <?php echo getFullNameByStafID(getServiceByByID($row_service['service_id'])) . " (" . getServiceByByID($row_service['service_id']) . ")"; ?></div>
                         <div class="txt_color1">Tempoh : <?php echo getServiceStartDateByID($row_service['service_id']) . " - " . getServiceEndDateByID($row_service['service_id']); ?></div>
                        </td>
                         <td align="center" valign="middle" nowrap="nowrap"><ul class="func"> <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 3)){?>
                      <li><a href="serviceedit.php?id=<?php echo getID(htmlspecialchars($row_service['service_id'],ENT_QUOTES));?>">Edit</a></li>
                      <?php }; ?>
                      <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?>
                      <li><a onclick="return confirm('Anda mahu maklumat perkhidmatan berikut dipadam? \r\n\n <?php echo $row_service['service_title']; ?>')" href="../sb/del_service.php?id=<?php echo getID(htmlspecialchars($row_service['service_id'],ENT_QUOTES));?>">X</a></li>
                      <?php }; ?>
                      </ul>
                      </td>
                       <td align="center" valign="middle" nowrap="nowrap">
                    <?php echo getCountDownByServiceID($row_service['service_id']);?>
                    </td>
                    </tr>
                      <?php $i++; } while ($row_service = mysql_fetch_assoc($service)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="txt_color1 noline"><?php echo $totalRows_service ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
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
mysql_free_result($jen);
mysql_free_result($service);
mysql_free_result($type);
?>
<?php include('../inc/footinc.php');?> 