<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/skt.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/sktfunc.php');?>
<?php $menu='15';?>
<?php $menu2='64';?>
<?php
if(isset($_GET['y']))
	$y = htmlspecialchars($_GET['y'], ENT_QUOTES);
else
	$y = date('Y');
?>
<?php
mysql_select_db($database_skt, $skt);
$query_akt = "SELECT * FROM skt.user_aktiviti WHERE user_stafid = '" . $row_user['user_stafid'] . "' AND useraktiviti_status=1 AND useraktiviti_year='" . $y . "' ORDER BY useraktiviti_id ASC";
$akt = mysql_query($query_akt, $skt) or die(mysql_error());
$row_akt = mysql_fetch_assoc($akt);
$totalRows_akt = mysql_num_rows($akt);
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
      	<?php include('../inc/menu_skt.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
                <li class="form_back">
                  <form id="form1" name="form1" method="get" action="kegiatan.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Tahun</td>
                        <td width="100%">
                          <select name="y" id="y">
                          <?php for($i=date('Y'); $i>=2012; $i--){?>
                            <option <?php if($y == $i) echo "selected=\"selected\"";?> value="<?php echo $i;?>"><?php echo $i;?></option>
                          <?php }; ?>
                          </select>
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Semak" /></td>
                        <td><input name="button4" type="button" class="submitbutton" id="button4" value="Tambah" onclick="MM_goToURL('parent','kegiatanadd.php');return document.MM_returnValue" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                <li>
                <div class="note">Senarai kegiatan/aktiviti bagi tahun <?php echo $y;?></div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <?php if ($totalRows_akt > 0) { // Show if recordset not empty ?>
<tr>
                      <th nowrap="nowrap">Bil</th>
                      <th width="100%" align="left" valign="middle" nowrap="nowrap">Kegiatan</th>
                      <th nowrap="nowrap">&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                    <?php
					mysql_select_db($database_skt, $skt);
					$query_prog = "SELECT * FROM skt.user_program WHERE useraktiviti_id = '" . $row_akt['useraktiviti_id'] . "' AND userprogram_status=1 ORDER BY userprogram_id ASC";
					$prog = mysql_query($query_prog, $skt) or die(mysql_error());
					$row_prog = mysql_fetch_assoc($prog);
					$totalRows_prog = mysql_num_rows($prog);
					?>
                    <tr class="on">
                      <td align="center" valign="top"><?php echo $i;?></td>
                      <td align="left" valign="top" class="txt_line">
                      <div><strong><a href="program.php?akt=<?php echo $row_akt['useraktiviti_id']; ?>"><?php echo $row_akt['useraktiviti_name']; ?></a></strong></div>
                      <div class="txt_color1">Peringkat : <?php echo getOrgArchByID($row_akt['orgarch_id']); ?></div>
                      <div class="txt_color1">Jawatan : <?php echo getOrgLevelByID($row_akt['orglevel_id']); ?> &nbsp; <?php echo getAktivitiJawatanByAktID($row_akt['useraktiviti_id']);?></div>
                      <?php if ($totalRows_prog > 0) { // Show if recordset not empty ?>
                        <div class="txt_color1">
                          <ol>
                            <?php do { ?>
                              <li><strong><?php echo $row_prog['userprogram_name']; ?></strong>, Peringkat<strong> <?php echo getOrgArchByID($row_prog['orgarch_id']); ?> </strong>sebagai<strong> <?php echo getOrgLevelByID($row_prog['orglevel_id']); ?></strong></li>
                              <?php } while ($row_prog = mysql_fetch_assoc($prog)); ?>
                          </ol>
                        </div>
                        <?php } // Show if recordset not empty ?>
                      </td>
                     <td align="center" valign="middle"><ul class="func">
                      <li><a onclick="return confirm('Anda mahu maklumat kegiatan berikut dipadam? \r\n\n <?php echo $row_akt['useraktiviti_name']; ?> \r\n Peringkat: <?php echo getOrgArchByID($row_akt['orgarch_id']); ?> \r\n\ Jawatan: <?php echo getOrgLevelByID($row_akt['orglevel_id']); ?> &nbsp; <?php echo getAktivitiJawatanByAktID($row_akt['useraktiviti_id']);?>')" href="../sb/del_kegiatan.php?id=<?php echo $row_akt['useraktiviti_id'];?>">X</a></li>
                      </ul>
                      </td>
                    </tr>
                    <?php
					mysql_free_result($prog);
					?>
                    <?php $i++; } while ($row_akt = mysql_fetch_assoc($akt)); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_akt ?> rekod dijumpai</td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
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
mysql_free_result($akt);
?>
<?php include('../inc/footinc.php');?> 