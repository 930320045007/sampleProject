<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='18';?>
<?php $menu2='98';?>
<?php
$wsql = "";

if(isset($_POST['doc_date_m']))
{
	$wsql .= " AND doc_date_m = '" . $_POST['doc_date_m'] . "'";
	$dm = $_POST['doc_date_m'];
} else {
	$wsql .= " AND doc_date_m = '" . date('m') . "'";
	$dm = date('m');
}

if(isset($_POST['doc_date_y']))
{
	$wsql .= " AND doc_date_y = '" . $_POST['doc_date_y'] . "'";
	$dy = $_POST['doc_date_y'];
} else {
	$wsql .= " AND doc_date_y = '" . date('Y') . "'";
	$dy = date('Y');
}
	
mysql_select_db($database_tadbirdb, $tadbirdb);
$query_doc = "SELECT * FROM tadbir.document WHERE doc_status = 1 " . $wsql . " AND doc_by = '" . $row_user['user_stafid'] . "' ORDER BY doc_date_d ASC, doc_date_m ASC, doc_date_y ASC ";
$doc = mysql_query($query_doc, $tadbirdb) or die(mysql_error());
$row_doc = mysql_fetch_assoc($doc);
$totalRows_doc = mysql_num_rows($doc);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<script language="javascript">
function checkForm(form)
{
	form.buttonfeedback.disabled=true;
	form.buttonfeedback.value="Proses...";
	return true;
}
</script>
<link href="../SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
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
                   	  <form id="form1" name="form1" method="post" action="record.php">
                   	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	      <tr>
                   	        <td class="label">Bulan</td>
                   	        <td width="100%">
                             <select name="doc_date_m" id="doc_date_m">
                          <?php for($j=1; $j<=12; $j++){?>
            	            <option <?php if($j==$dm) echo "selected=\"selected\"";?> value="<?php if($j<10) $j= "0" . $j; echo $j;?>"><?php echo $j . " - " . date('M', mktime(0, 0, 0, $j, 1, date('Y')));?></option>
                          <?php }; ?>
          	            </select>
            	        <select name="doc_date_y" id="doc_date_y">
                          <?php for($k=2012; $k<=date('Y'); $k++){?>
            	            <option <?php if($k==$dy) echo "selected=\"selected\"";?> value="<?php echo $k;?>"><?php echo $k;?></option>
                          <?php }; ?>
          	            </select>
               	            <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
               	          </tr>
               	        </table>
                  	  </form>
                    </li>
                	<li><div class="note">Rekod bagi bulan <?php echo date('M Y', mktime(0, 0, 0, $dm, 1, $dy));?></div></li>
                	<li class="title">Rekod Dokumen</li>
					  <?php if ($totalRows_doc > 0) { // Show if recordset not empty ?><div class="line_b">
                      <li>
  					<table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <th align="left" valign="middle">Bil</th>
                      <th width="20%" align="left" valign="middle">Tarikh</th>
                      <th width="20%" align="left" valign="middle">No Rujukan</th>
                      <th width="100%" align="left" valign="middle">Perkara</th>
                    </tr>
                    </table>
					</li>
                   
               <?php $i=1; do { ?>
               <div class="line_b">
                <li>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
<td class="noline"><?php echo $i;?></td>
                            <td width="20%" align="left" nowrap="nowrap"><?php echo getDateDocByDocID($row_doc['doc_id']);?></td>
                            <td width="20%" valign="middle" align="left" nowrap="nowrap"><?php echo getRefNoByDocID($row_doc['doc_id']); ?></td>
                            <td width="100%" align="left" class="noline">
                            <span class="cursorpoint" onClick="toggleview2('formdi<?php echo $row_doc['doc_id']; ?>'); return false;"><strong><?php echo getDocTitleByDocID($row_doc['doc_id']); ?></strong> <div>    
                            &nbsp; &bull; &nbsp; Jenis : <?php echo getDocCategoryNameByDocCategoryID($row_doc['category_id']);?></div>
                            </span>
                            </td>
                          </tr>
                          </table>
                         </li>
                          <div id="formdi<?php echo $row_doc['doc_id']; ?>" class="hidden2">
                            <li class="line_dot">
                            <?php
							mysql_select_db($database_tadbirdb, $tadbirdb);
							$query_status = "SELECT * FROM tadbir.doc_status LEFT JOIN tadbir.doc_checkout  ON doc_status.user_stafid = doc_checkout.docout_by AND doc_status.doc_id = doc_checkout.doc_id WHERE docstatus_status = '1' AND doc_status .doc_id = '" . $row_doc['doc_id'] . "' ORDER BY docstatus_id ASC, docstatus_date_in ASC";
							$status = mysql_query($query_status, $tadbirdb) or die(mysql_error());
							$row_status = mysql_fetch_assoc($status);
							$totalRows_status = mysql_num_rows($status);
							?>
                            <?php if ($totalRows_status > 0) { // Show if recordset not empty ?> 
							  <?php $j=1; do { ?>
                              <table width="100%" border="0" cellspacing="0" cellpadding="0">
							      <tr>
                                  <td align="left"><div class="txt_line"><?php echo $i . "." . $j;?></div></td>
							        <td width="30%" align="left"><strong><?php echo getFullNameByStafID($row_status['user_stafid']);?></strong><div><?php echo getFulldirectory(getDirIDByUser($row_status['user_stafid']),0);?> </div></td>
							        <td width="20%" align="left"><?php echo $row_status['docstatus_date_in'];?></td>
                                    <td width="20%" align="left"><?php echo $row_status['docout_date'];?></td>
                                    <td width= "30%" align="left" nowrap="nowrap"><?php echo $row_status['docout_note'];?></td>
						          </tr>
                                  </table>
						      <?php $j++; } while ($row_status = mysql_fetch_assoc($status)); ?>
                              
							<?php } else { ?>
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td  colspan="4" width="100%" align="center" valign="top">Tiada Rekod</td>
                                  </tr>
                                </table>
                              <?php }; ?>
							<?php mysql_free_result($status);?>
                            </li>
                            </div>
                            </div>
                          <?php
						  $i++;
                            } while ($row_doc = mysql_fetch_assoc($doc));
                              $rows = mysql_num_rows($doc);
                              if($rows > 0) {
                                  mysql_data_seek($doc, 0);
                                  $row_doc = mysql_fetch_assoc($doc);
                              }
                            ?> 
                        <?php } else { ?>
                        <li class="line_b">
                         <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr>
                          <td colspan="4" align="center" valign="middle">Tiada rekod dijumpai</td>
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
mysql_free_result($doc);

?>
<?php include('../inc/footinc.php');?> 