<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='18';?>
<?php $menu2='97';?>
<?php
$c = "";

if(isset($_GET['c']) && $_GET['c'] != NULL)
{
	$c = " AND (docin_refno LIKE '%" . htmlspecialchars($_GET['c'], ENT_QUOTES) . "%' OR docout_refno LIKE '%" . htmlspecialchars($_GET['c'], ENT_QUOTES) . "%')";	
}

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_doc = "SELECT * FROM tadbir.doc_checkin LEFT JOIN tadbir.doc_checkout ON doc_checkin.docin_by = doc_checkout.docout_by WHERE docin_status = 1 AND docout_status = 1 " . $c . " GROUP BY docin_by ORDER BY docin_date_d ASC, docin_date_m ASC, docin_date_y ASC";
$doc = mysql_query($query_doc, $tadbirdb) or die(mysql_error());
$row_doc = mysql_fetch_assoc($doc);
$totalRows_doc = mysql_num_rows($doc);


	
//mysql_select_db($database_tadbirdb, $tadbirdb);
//$query_doc = "SELECT * FROM tadbir.doc_checkin LEFT JOIN tadbir.doc_checkout ON doc_checkout.docout_refno = doc_checkin.docin_refno WHERE docin_status = 1 AND docout_status =1 " . $c . " ORDER BY docin_date_d ASC, docin_date_m ASC, docin_date_y ASC";
//$doc = mysql_query($query_doc, $tadbirdb) or die(mysql_error());
//$row_doc = mysql_fetch_assoc($doc);
//$totalRows_doc = mysql_num_rows($doc);
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
        <?php include('../inc/menu_document.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="status.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Carian</td>
                        <td width="40%"><input name="c" type="text" id="c" value="<?php if(isset($_GET['c']) && $_GET['c'] != NULL) echo $_GET['c'];?>" /></td>
                        <td width="100%">
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li> 
				<?php if(isset($_GET['c'])){?>
                <div class="note">Senarai Maklumat Minit Bebas /Memo No Rujukan</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                 
                  <?php if ($totalRows_doc > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle" nowrap="nowrap">No. Rujukan</th>
                      <th width="100%" align="left" valign="middle">Kakitangan</th>
                      <th align="center" valign="middle">Waktu Masuk</th>
                      <th align="center" valign="middle">Waktu Keluar</th>
                    </tr>
                    <?php do { ?>
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo  $row_doc['docin_refno'];?></td>
                        <td align="left" valign="middle" class="txt_line"><div><strong><?php echo getFullNameByStafID($row_doc['docin_by']) . " (" . $row_doc['docin_by'] . ")";?></strong></div>
                     <div><?php echo getFulldirectoryByUserID($row_doc['docin_by']);?> </div></td>
                     <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_doc['docin_date_h'] . " " . date('d/m/Y ', mktime(0,0,0,$row_doc['docin_date_m'], $row_doc['docin_date_d'],$row_doc['docin_date_y']));?></td>
                     <td align="center" valign="middle" nowrap="nowrap"><?php echo $row_doc['docout_date_h'] . " " . date('d/m/Y ', mktime(0,0,0,$row_doc['docout_date_m'], $row_doc['docout_date_d'],$row_doc['docout_date_y']));?></td>
                    </tr>
                    <?php  } while ($row_doc = mysql_fetch_assoc($doc)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_doc ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                  <?php }else { ?>
                  <table>
                  <tr>
                   <td colspan="4" align="center" valign="middle" class="noline">Sila buat Carian menggunakan No Rujukan Minit / Memo</td>
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
mysql_free_result($doc);

?>
<?php include('../inc/footinc.php');?> 