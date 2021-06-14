<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='18';?>
<?php $menu2='96';?>
<?php 


mysql_select_db($database_tadbirdb, $tadbirdb);
$query_doc = "SELECT * FROM tadbir.document_receiver WHERE NOT EXISTS (SELECT * FROM tadbir.doc_status WHERE doc_status.user_stafid = document_receiver.docreceiver_staf AND doc_status.doc_id= document_receiver.doc_id AND docstatus_date_in !='NULL') AND docreceiver_staf = '".$row_user['user_stafid'] . "' AND docreceiver_status = 1 ORDER BY document_receiver.doc_id DESC";
$doc = mysql_query($query_doc, $tadbirdb) or die(mysql_error());
$row_doc = mysql_fetch_assoc($doc);
$totalRows_doc = mysql_num_rows($doc);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_docout = "SELECT * FROM tadbir.document_receiver WHERE NOT EXISTS (SELECT * FROM tadbir.doc_checkout WHERE doc_checkout.docout_by= document_receiver.docreceiver_staf AND doc_checkout.doc_id = document_receiver.doc_id AND docout_date !='NULL') AND docreceiver_staf = '".$row_user['user_stafid'] . "' AND docreceiver_status = 1 ORDER BY document_receiver.doc_id DESC";
$docout = mysql_query($query_docout, $tadbirdb) or die(mysql_error());
$row_docout = mysql_fetch_assoc($docout);
$totalRows_docout = mysql_num_rows($docout);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
            <form action="../sb/add_delivery.php" method="POST" id="form1" name="form1"> 
             <li class="gap">&nbsp;</li> 
             <li class="title">Minit Masuk</li>
                <li class="gap">&nbsp;</li> 
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_doc > 0) { // Show if recordset not empty ?>
                  <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="left" valign="middle">Tarikh</th>
                      <th align="left" valign="middle" nowrap="nowrap">No Rujukan</th>
                      <th width="50%" align="left" valign="middle">Perkara</th>
                       <th align="left" valign="middle">&nbsp;</th>
                    </tr>
                        <?php $i=1; do { ?>  
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo getDateDocByDocID($row_doc['doc_id']);?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo getRefNoByDocID($row_doc['doc_id']); ?></td>  
                    <td align="left" valign="middle"><strong><?php echo getDocTitleByDocID($row_doc['doc_id']); ?></strong><div>&nbsp; &bull; &nbsp; Jenis : <?php echo getDocCategoryNameByDocCategoryID(getCategoryIDByDocID($row_doc['doc_id']));?></div></td>
					
                            <td><?php if(getDocDateInByDocID($row_user['user_stafid'], $row_doc['doc_id']) == NULL); { ?>
                            <input name="doc_id" type="hidden" id="doc_id" value="<?php echo $row_doc['doc_id'];?>" />     
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Masuk"/><input type="hidden" name="MM_insert" value="dokumen"/><?php };?>
                         </td> 
                    </tr>
                    <?php $i++; } while ($row_doc = mysql_fetch_assoc($doc)); ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_doc ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="5" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                </form>
              <form action="../sb/add_docout.php" method="POST" id="form1" name="form1"> 
             <li class="gap">&nbsp;</li> 
             <li class="title">Minit Keluar</li>
                <li class="gap">&nbsp;</li> 
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_docout > 0) { // Show if recordset not empty ?>
                  <tr>
                      <th align="center" valign="middle" nowrap="nowrap">Bil</th>
                      <th align="left" valign="middle">Tarikh</th>
                      <th align="left" valign="middle" nowrap="nowrap">No Rujukan</th>
                      <th width="30%" align="left" valign="middle">Perkara</th>
                       <th align="center" valign="middle">Catatan</th>
                       <th align="left" valign="middle">&nbsp;</th>
                    </tr>
                        <?php $i=1; do { ?>  
                      <tr class="on">
                        <td align="center" valign="middle" nowrap="nowrap"><?php echo $i;?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo getDateDocByDocID($row_docout['doc_id']);?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo getRefNoByDocID($row_docout['doc_id']); ?></td>  
                    <td align="left" valign="middle"><strong><?php echo getDocTitleByDocID($row_docout['doc_id']); ?></strong><div>&nbsp; &bull; &nbsp; Jenis : <?php echo getDocCategoryNameByDocCategoryID(getCategoryIDByDocID($row_docout['doc_id']));?></div></td>
                    <td>
                    <textarea name="docout_note" cols="45" rows="5" id="docout_note" onkeypress="return handleEnter(this, event)"></textarea></td>
                            <td>
                            <input name="doc_id" type="hidden" id="doc_id" value="<?php echo $row_docout['doc_id'];?>" />     
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Keluar"/><input type="hidden" name="MM_insert" value="dokumenkeluar"/>
                         </td> 
                    </tr>
                    <?php $i++;} while ($row_docout = mysql_fetch_assoc($docout)); ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_docout ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="6" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                  <?php }; ?>
                  </table>
                </li>
                </form>
                
            </ul>
            </div>
        </div>
        </div> 
		<?php include('../inc/footer.php');?>
    </div>
</body>
</html>
<?php include('../inc/footinc.php');?> 