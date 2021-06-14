<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/financedb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/financefunc.php');?>
<?php $menu='17';?>
<?php $menu2='87';?>
<?php

$id = "-1";

if (isset($_GET['id'])) {
  $id = getID(htmlspecialchars($_GET['id'], ENT_QUOTES),0);
};


mysql_select_db($database_financedb, $financedb);
$query_apply = sprintf("SELECT * FROM finance.apply LEFT JOIN finance.jkb ON jkb.jkb_id=apply.jkb_id WHERE jkb.jkb_id=%s AND apply_status = '1' AND jkb_status = '1' AND user_stafid = '" . $row_user['user_stafid'] . "' ORDER BY apply_id ASC",GetSQLValueString($id,"int"));
$apply = mysql_query($query_apply, $financedb) or die(mysql_error());
$row_apply = mysql_fetch_assoc($apply);
$totalRows_apply = mysql_num_rows($apply);

mysql_select_db($database_financedb, $financedb);
$query_jkb = sprintf("SELECT * FROM finance.jkb WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND jkb_id=%s AND jkb_status = 1 ORDER BY jkb_id DESC",GetSQLValueString($id,"int"));
$jkb = mysql_query($query_jkb, $financedb) or die(mysql_error());
$row_jkb = mysql_fetch_assoc($jkb);
$totalRows_jkb = mysql_num_rows($jkb);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href='http://fonts.googleapis.com/css?family=Source+Code+Pro:300' rel='stylesheet' type='text/css'>
<link href="../css/print.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
</head>
<body onLoad="javascript:window.print()">

<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
<tr>
    <td align="center" valign="middle" nowrap="nowrap"><img src="<?php echo $url_main;?>img/isn.png" width="75" height="70" alt="isn" /></td>
    <td width="100%" align="left" valign="middle" nowrap="nowrap" class="fsize2"><strong>INSTITUT SUKAN NEGARA</strong><br />
    Permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktivitivi</td>
    <td align="left" valign="middle" nowrap="nowrap">Tarikh : <?php echo date('d / m / Y (D)', mktime(0 , 0, 0, date('m'), date('d'), date('Y')));?></td>
</tr>
</table>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="middle" nowrap="nowrap">Permohonan Jawatankuasa Bantuan Pelaksanaan Program / Aktiviti Institut Sukan Negara </td>
      </tr>
      <tr>
        <td align="center" valign="middle" nowrap="nowrap">&nbsp;</td>
        </tr>
        <tr>
     <td align="left" valign="middle" nowrap="nowrap"><strong>Bahagian : <?php echo getFulldirectory(getDirIDByUser($row_user['user_stafid']));?></strong></td> 
      </tr>
       <tr>
        <td align="left" valign="middle" nowrap="nowrap">&nbsp;</td>
      </tr>
 </table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Kategori</td>
          <td width="100%"><?php echo getCategory($id); ?></td>
        </tr>
         <tr class="line_b">
          <td nowrap="nowrap" class="label">Cawangan / <br />
Pusat / Unit</td>
          <td><?php echo getFullDirectory(getDirIDByJkbID($id)); ?></td>
        </tr>
        <tr class="line_b">
          <td class="label" nowrap="nowrap">No. Rujukan</td>
           <td><?php echo getJkbRefByID($id); ?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Aktiviti</td>
          <td> <?php echo getJkbActivityByID($id);?></td>
        </tr>
        <tr class="line_b">
          <td valign="middle" nowrap="nowrap" class="label">Perihal</td>
          <td><?php if(getJkbDetailByID($id)!=NULL) echo getJkbDetailByID($id); else echo '-';?></td>
        </tr>
      </table>
     <?php if ($totalRows_apply > 0) { // Show if recordset not empty ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
           <td align="left" valign="middle" nowrap="nowrap">Maklumat Permohonan</td>
        </tr>
	</table>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabborder">
   <tr>
      <th nowrap="nowrap">Bil</th>
      <th align="left" nowrap="nowrap">Deskripsi/Perbelanjaan Dipohon</th>
      <th width="50%" align="center" valign="middle" nowrap="nowrap">Kuantiti</th>
      <th align="left" nowrap="nowrap">Pengiraan </th>
      <th width="50%" align="center" valign="middle" nowrap="nowrap">Jumlah Perbelanjaan(RM)</th>
       <th align="left" nowrap="nowrap">Kelulusan : Lulus( / ) Tidak Lulus( X )</th>
    </tr>
       <?php $i=1; do { ?>
            <tr class="line_b">
              <td><?php echo $i;?></td>
              <td align="left" nowrap="nowrap"><?php echo $row_apply['apply_description']; ?></td>
              <td align="center" nowrap="nowrap"><?php echo $row_apply['apply_quantity']; ?></td>
              <td align="left" nowrap="nowrap"><?php echo $row_apply['apply_calculation']; ?></td>
              <td align="center" nowrap="nowrap"><?php echo number_format($row_apply['apply_amount'],2); ?></td>
              <td align="center" nowrap="nowrap">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</td>
            </tr>
                          <?php $i++; } while ($row_apply = mysql_fetch_assoc($apply)); ?>
           <tr>
              <td colspan="4" align="right"></td>
              <td align="center" class="back_darkgrey"><strong><?php echo number_format(getAmountByJkbID($id),2); ?></strong></td>
            </tr> 
    </table>
      <?php }; ?>
      <br/><br/>
      <table width="50%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
          <td>Catatan/ Ulasan :</td>
        </tr>
        <tr>
          <td colspan="3" class="tabborder"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
</table>
   <br/><br/>
      <table width="50%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
        <tr>
          <td colspan="3" class="tabborder"><p>&nbsp;</p>
          <p>&nbsp;</p>
          <p>&nbsp;</p></td>
        </tr>
        <tr>
          <td colspan="3">Tandatangan &amp; Cop Rasmi</td>
        </tr>
</table>      
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td>Oleh</td>
        </tr>
        </table>
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
            <tr>
              <td class="box">&nbsp;</td>
              <td nowrap="nowrap">Ketua Pegawai Eksekutif(KPE)</td>
              <td class="box">&nbsp;</td>
              <td width="100%">Pengarah Bahagian</td>
            </tr>
          </table>   
        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>Tarikh</td>
        </tr>
</table>      
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="tabinfo">
            <tr>
              <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
              <td>/</td>
              <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
              <td>/</td>
              <td nowrap="nowrap" class="box">&nbsp; &nbsp; &nbsp; </td>
              <td width="100%">&nbsp;</td>
            </tr>
            <tr>
              <td colspan="6" nowrap="nowrap" >&nbsp;</td>
            </tr>
</table>
  <br />
     <br /><br />
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="tabinfo">
      <tr>
        <td align="left" valign="top" nowrap="nowrap"><img src="<?php echo $url_main;?>qr/qrjkb.php?jid=<?php echo $id;?>" alt="" /></td>
        <td width="100%" align="left" valign="middle">Borang ini adalah cetakan melalui <?php echo $systitle_full;?> (<?php echo $systitle_short;?>)<br/>
              <br />
              <?php echo time();?></td>
      </tr>
    </table>       
</body>
</html>
<?php
mysql_free_result($jkb);
mysql_free_result($apply);
?>
<?php include('../inc/footinc.php');?> 
              