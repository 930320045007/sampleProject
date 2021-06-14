<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='64';?>
<?php
$y = date('Y');
?>
<?php
if(isset($_GET['akt']))
	$akt = htmlspecialchars($_GET['akt'], ENT_QUOTES);
else
	$akt = "-1";
	
mysql_select_db($database_skt, $skt);
$query_prog = "SELECT * FROM skt.user_program WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND useraktiviti_id = '" . $akt . "' AND userprogram_status=1 AND userprogram_year='" . $y . "' ORDER BY userprogram_id ASC";
$prog = mysql_query($query_prog, $skt) or die(mysql_error());
$row_prog = mysql_fetch_assoc($prog);
$totalRows_prog = mysql_num_rows($prog);
?>
<?php
mysql_select_db($database_skt, $skt);
$query_orgarch = "SELECT * FROM skt.org_arch WHERE orgarch_status = 1 ORDER BY orgarch_name ASC";
$orgarch = mysql_query($query_orgarch, $skt) or die(mysql_error());
$row_orgarch = mysql_fetch_assoc($orgarch);
$totalRows_orgarch = mysql_num_rows($orgarch);

mysql_select_db($database_skt, $skt);
$query_orglevel = "SELECT * FROM skt.org_level WHERE orglevel_status = 1 ORDER BY orglevel_name ASC";
$orglevel = mysql_query($query_orglevel, $skt) or die(mysql_error());
$row_orglevel = mysql_fetch_assoc($orglevel);
$totalRows_orglevel = mysql_num_rows($orglevel);
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
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <div class="note">Senarai program dibawah kegiatan/aktiviti <strong><?php echo getAktivitiNameByAktID($akt);?></strong> bagi tahun <strong><?php echo $y;?></strong></div>
            <ul>
            	<li class="title"><?php echo getAktivitiNameByAktID($akt);?> <?php if($akt!="-1"){?><span class="fr add" onclick="toggleview2('formprog'); return false;">Tambah</span><?php }; ?></li>
                <?php if($akt!="-1"){?>
                <div id="formprog" class="hidden">
                <li>
                  <form id="form1" name="form1" method="post" action="../sb/add_sktprogram.php">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Tahun</td>
                      <td>
                        <select name="userprogram_year" id="userprogram_year">
                          <option value="<?php echo date('Y');?>"><?php echo date('Y');?></option>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="label">Nama Program *</td>
                      <td>
                      <span id="nameprog">
                      <span class="textfieldRequiredMsg">Maklumat diperlukan.</span>
                        <input type="text" name="userprogram_name" id="userprogram_name" />
                      <div class="inputlabel2">Cth: Pertandingan Antara Bahagian</div>
                      </span>
                      </td>
                    </tr>
                    <tr>
                      <td class="label">Peringkat</td>
                      <td>
                        <select name="orgarch_id" id="orgarch_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_orgarch['orgarch_id']?>"><?php echo $row_orgarch['orgarch_name']?></option>
                          <?php
							} while ($row_orgarch = mysql_fetch_assoc($orgarch));
							  $rows = mysql_num_rows($orgarch);
							  if($rows > 0) {
								  mysql_data_seek($orgarch, 0);
								  $row_orgarch = mysql_fetch_assoc($orgarch);
							  }
							?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="label">Jawatan</td>
                      <td>
                        <select name="orglevel_id" id="orglevel_id">
                          <?php
							do {  
							?>
                          <option value="<?php echo $row_orglevel['orglevel_id']?>"><?php echo $row_orglevel['orglevel_name']?></option>
                          <?php
							} while ($row_orglevel = mysql_fetch_assoc($orglevel));
							  $rows = mysql_num_rows($orglevel);
							  if($rows > 0) {
								  mysql_data_seek($orglevel, 0);
								  $row_orglevel = mysql_fetch_assoc($orglevel);
							  }
							?>
                      </select></td>
                    </tr>
                    <tr>
                      <td class="label">Ringkasan Jawatan</td>
                      <td>
                      <input type="text" name="userprogram_jawat" id="userprogram_jawat" />
                      <div class="inputlabel2">Cth: AJK Kebajikan</div></td>
                    </tr>
                    <tr>
                      <td class="label noline">
                  		<input type="hidden" name="MM_insert" value="form1" />
                      <input name="useraktiviti_id" type="hidden" id="useraktiviti_id" value="<?php echo $akt;?>" />
                      <input name="id" type="hidden" id="id" value="<?php echo $row_user['user_stafid'];?>" />
                      </td>
                      <td class="noline">
                      <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','kegiatan.php');return document.MM_returnValue" />
                      </td>
                    </tr>
                  </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <div id="prog">
                <li class="gap">&nbsp;</li>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php if ($totalRows_prog > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Kegiatan</th>
                      <th align="center" valign="middle" nowrap="nowrap">Peringkat</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                    <tr class="on">
                      <td><?php echo $i;?></td>
                      <td align="left" valign="middle" class="txt_line"><?php echo $row_prog['userprogram_name']; ?><span class="txt_color1"> &nbsp; &bull; &nbsp; <?php echo getOrgLevelByID($row_prog['orglevel_id']); ?></span> <span class="txt_color1"><?php echo getAktivitiJawatanByAktID($row_prog['useraktiviti_id']);?></span></td>
                      <td align="center" valign="middle" nowrap="nowrap"><?php echo getOrgArchByID($row_prog['orgarch_id']); ?></td>
                       <td align="center" valign="middle"><ul class="func">
                      <li><a onclick="return confirm('Anda mahu maklumat program berikut dipadam? \r\n\n <?php echo $row_prog['userprogram_name']; ?>\r\n\ Jawatan: <?php echo getOrgLevelByID($row_prog['orglevel_id']); ?> &nbsp; <?php echo getAktivitiJawatanByAktID($row_prog['useraktiviti_id']);?>')" href="../sb/del_program.php?id=<?php echo $row_prog['userprogram_id'];?>">X</a></li>
                      </ul>
                      </td>
                    </tr>
                    <?php $i++; } while ($row_prog = mysql_fetch_assoc($prog)); ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_prog ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="4" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                </div>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("nameprog");
</script>
</body>
</html>
<?php
mysql_free_result($prog);
?>
<?php
mysql_free_result($orgarch);

mysql_free_result($orglevel);
?>
<?php include('../inc/footinc.php');?> 