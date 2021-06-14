<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/tadbirdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/tadbirfunc.php');?>
<?php $menu='10';?>
<?php $menu2='79';?>
<?php
if(isset($_GET['id']) && $_GET['id']!=NULL)
	$transbookid = getID($_GET['id'], 0);
else
	$transbookid = '0';

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_tr = "SELECT * FROM transport_book WHERE transbook_id= '". $transbookid . "' AND transbook_status = 1 ORDER BY transbook_id ASC";
$tr = mysql_query($query_tr, $tadbirdb) or die(mysql_error());
$row_tr = mysql_fetch_assoc($tr);
$totalRows_tr = mysql_num_rows($tr);

mysql_select_db($database_tadbirdb, $tadbirdb);
$query_feedback = sprintf("SELECT * FROM user_feedback WHERE transbook_id = %s", GetSQLValueString($transbookid, "int"));
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
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
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
           <form id="userfeedback" name="userfeedback" method="POST" action="../sb/add_userfeedback.php">
          	<ul>
                <li class="title">Maklum balas</li>
                <li>
                <div class="note">Tidak Memuaskan 1 - 5 Sangat Baik</div>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="label">Penggunaan Borang Tempahan Manual</td>
                      <td>
                       <?php echo $row_feedback['userfeedback_q1']; ?>
                      </td>
                    </tr>
                    <tr>
                     <td class="label">Penggunaan Borang Tempahan Online</td>
                      <td>
                      <?php echo $row_feedback['userfeedback_q2']; ?>
                      </td>
                    <tr>
                      <td class="label">Pemandu memastikan keselamatan diri dan pelanggan terjamin</td>
                      <td>
                       <?php echo $row_feedback['userfeedback_q3']; ?>
                      </td>
                      </tr>
                      <tr>
                      <td class="label">Laluan yang dipilih pemandu menepati keperluan pelanggan</td>
                      <td>
                        <?php echo $row_feedback['userfeedback_q4']; ?>
                      </td>
                      </tr>
                      <tr>
                      <td class="label">Mesra pelanggan (e.g Senyum Selalu)</td>
                      <td>
                        <?php echo $row_feedback['userfeedback_q5']; ?>
                      </td>
                      </tr>
                      <tr>
                      <td class="label">Menepati masa mengikut tempahan</td>
                      <td>
                        <?php echo $row_feedback['userfeedback_q6']; ?>
                      </td>
                     </tr>
                     <tr>
                     <td class="label">Kenderaan dalam keadaan baik dan selamat</td>
                      <td>
                       <?php echo $row_feedback['userfeedback_q7']; ?>
                      </td>
                     </tr>
                     <tr>
                     <td class="label">Pemanduan yang berhemah</td>
                      <td>
                        <?php echo $row_feedback['userfeedback_q8']; ?>
                      </td>
                     </tr>
                     <tr>
                     <td class="label">Tiada sebarang kerosakan/kemalangan berlaku sepanjang perjalanan</td>
                      <td>
                      <?php echo $row_feedback['userfeedback_q9']; ?>
                      </td>
                     </tr>
                     <tr>
                     <td class="label">Teknik pemanduan yang selamat dan selesa</td>
                      <td>
                       <?php echo $row_feedback['userfeedback_q10']; ?>
                      </td>
                     </tr>
                    <tr>
                      <td class="label">Maklum balas</td>
                      <td>
                      <?php echo $row_feedback['userfeedback_comment'];?>
                      </td>
                    </tr>
                    <tr>
                  
                    </tr>
                  </table>
                </li>
            </ul>
           </form>
          </div>
        </div>
        <?php echo noteFooter('1');?>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
</body>
</html>
<?php
mysql_free_result($tr);

?>
<?php include('../inc/footinc.php');?> 