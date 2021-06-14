<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='9';?>
<?php $menu2='56';?>
<?php
if(isset($_GET['id']) && $_GET['id']!=NULL)
	$transbookid = getID(htmlspecialchars($_GET['id'],ENT_QUOTES), 0);
else
	$transbookid = '0';

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM transport_book WHERE transbook_id= '". $transbookid . "' AND transbook_status = 1 ORDER BY transbook_id ASC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_feedback = "SELECT * FROM tadbir.feedback WHERE feedback_status = 1 ORDER BY feedback_id DESC";
$feedback = mysql_query($query_feedback, $tadbirdb) or die(mysql_error());
$row_feedback = mysql_fetch_assoc($feedback);
$totalRows_feedback = mysql_num_rows($feedback);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
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
          <?php if(!checkFeedback($transbookid) && checkAdminAppByID($transbookid)) { ?>
           <form id="userfeedback" name="userfeedback" method="POST" action="../sb/add_userfeedback.php">
          	<ul>  
             <li>
                  <div class="note txt_line">Skala Pemarkahan : <br>
                1 - Sangat Tidak Memuaskan / Sangat Tidak Bersetuju, 2 - Tidak Memuaskan / Tidak Bersetuju, 3 - Sederhana, 4 - Memuaskan / Bersetuju, 5 - Sangat Memuaskan / Sangat Bersetuju</div></li> 
                <li class="title">Maklum balas</li>
				  <?php if ($totalRows_feedback > 0) { // Show if recordset not empty ?>
                <li>
                <div class="padb">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <th>Bil</th>
                        <th width="100%" align="left" valign="middle">Perkara</th>
                        <th nowrap="nowrap">
                    	<ul class="inputradiolabel">
                              <li>1</li>
                              <li>2</li>
                              <li>3</li>
                              <li>4</li>
                              <li>5</li>
                          </ul>
                        </th>
                    </tr>
                     <?php $i=1; do {?>
                      <tr class="on">
                        <td><?php echo $i;?></td>
                        <td width="100%"><?php echo $row_feedback['feedback_name']; ?><input name="fid[]" type="hidden" value="<?php echo $row_feedback['feedback_id']; ?>" /></td>
                          <td nowrap="nowrap">
                         <ul class="inputradio">
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_feedback['feedback_id']; ?>" value="1" id="jawab_0<?php echo $row_feedback['feedback_id']; ?>" />
                              </li>
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_feedback['feedback_id']; ?>" value="2" id="jawab_1<?php echo $row_feedback['feedback_id']; ?>" />
                              </li>
                              <li>
                                  <input checked="checked" type="radio" name="jawab<?php echo $row_feedback['feedback_id']; ?>" value="3" id="jawab_2<?php echo $row_feedback['feedback_id']; ?>" />
                              </li>
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_feedback['feedback_id']; ?>" value="4" id="jawab_3<?php echo $row_feedback['feedback_id']; ?>" />
                              </li>
                              <li>
                                  <input type="radio" name="jawab<?php echo $row_feedback['feedback_id']; ?>" value="5" id="jawab_4<?php echo $row_feedback['feedback_id']; ?>" />
                              </li>
                          </ul>
                          </td>
                          </tr> 
                      <?php $i++; } while ($row_feedback = mysql_fetch_assoc($feedback)); 
						mysql_free_result($feedback); ?>
                    <tr>
                      <td colspan="3" align="center" valign="middle" class="noline txt_color1"><?php echo $totalRows_feedback ?> rekod dijumpai</td>
                    </tr>
                  </table>
                  </div>
                  </li>
                     <?php }; // Show if recordset not empty ?>
                    <li class="form_back2 padt">
                <span id="sah">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td width="10%" nowrap>
                        <input name="checkbox" type="checkbox" id="checkbox" value="1" />
                      </td>
                      <td width="90%" class="txt_line"><span class="checkboxRequiredMsg">&laquo; Sila buat pengesahan</span>
                      <div>Saya mengesahkan semua maklum balas yang diberikan adalah sahih berdasarkan pandangan dan penilaian saya terhadap pengalaman dan pengetahuan berkaitan tanpa melibatkan paksaan atau emosi.</div></td>
                    </tr>
                    <tr>
                      <td class="noline"><input type="hidden" name="MM_insert" value="formfeedback" />
                    <input name="transbookid" type="hidden" id="transbookid" value="<?php echo getID(htmlspecialchars($_GET['id'],ENT_QUOTES),0);?>" /></td>
                      <td class="noline"><input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" />
                      <input name="button4" type="button" class="cancelbutton" id="button4" value="Batal" onclick="MM_goToURL('parent','<?php echo $url_main;?>tadbir/record.php');return document.MM_returnValue" /></td>
                    </tr>
                    </table>
                     </span>
                </li>
            </ul>
           </form>
           <?php } else { ?>
           <ul>
           	<li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline">Tiada rekod dijumpai</td>
                </tr>
              </table>
            </li>
           </ul>
           <?php }; ?>
          </div>
        </div>
        <?php echo noteFooter('1');?>
        <?php echo noteMade($menu);?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("sah");
</script>
</body>
</html>
<?php
mysql_free_result($tr);
mysql_free_result($feedback);

?>
<?php include('../inc/footinc.php');?> 