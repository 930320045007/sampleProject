<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ideasdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/admin_sta.php');?>
<?php include('../inc/ideasfunc.php');?>
<?php $menu='14';?>
<?php $menu2='86';?>
<?php
if(isset($_GET['idstype_id']))
	$typeid = htmlspecialchars($_GET['idstype_id'], ENT_QUOTES);
else
	$typeid = 0;
	
if(isset($_GET['ids_date_m']))
	$m = htmlspecialchars($_GET['ids_date_m'], ENT_QUOTES);
else
	$m = 0;
	
if(isset($_GET['ids_date_y']))
	$y = htmlspecialchars($_GET['ids_date_y'], ENT_QUOTES);
else
	$y = 0;
	
if(isset($_GET['sb']))
	$ob = htmlspecialchars($_GET['sb'], ENT_QUOTES);
else
	$ob = 0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<link href="../SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
<?php include('../inc/headinc.php');?>
<script src="../SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
</head>
<body <?php include('../inc/bodyinc.php');?>>
<div>
	<div>
		<?php include('../inc/header.php');?>
      <?php include('../inc/menu.php');?>
        
      	<div class="content">
        <?php include('../inc/menu_qna.php');?>
        <div class="tabbox">
        	<div class="profilemenu">
            <ul>
            	<li class="form_back">
                  <form id="formCarian" name="formCarian" method="get" action="index.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td width="100%">
                        <select name="select" id="select" onchange="dochange('19', 'stype', this.value, '0');">
                          <option value="0">Jenis carian </option>
                          <option value="1">Kategori</option>
                          <option value="2">Bulan / Tahun</option>
                          <option value="3">Susunan mengikut</option>
                        </select>
                        <div id="stype">
                        </div>
                        </td>
                        <?php if(!checkUserByDate($row_user['user_stafid'])){?>
                        <td><input name="button5" type="button" class="submitbutton" id="button5" value="Tambah" onClick="toggleview2('formIdeas'); return false;" /></td>
                        <?php }; ?>
                      </tr>
                    </table>
                  </form>
                </li>
                <?php if(!checkUserByDate($row_user['user_stafid'])){?>
                <div id="formIdeas" class="hidden">
                <li>
                <span id="detail">
                  <form id="form1" name="form1" method="post" action="../sb/add_ideas.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Kategori</td>
                        <td width="100%"><select name="idstype_id" id="idstype_id">
                          <?php foreach(getAllIdeasTypeID() AS $idstype_key => $idstypevalue){?>
                          <option value="<?php echo $idstypevalue;?>"><?php echo getIdeasTypeNameByID($idstypevalue);?></option>
                          <?php }; ?>
                        </select></td>
                      </tr>
                      <tr>
                        <td colspan="2" class="txt_line">
                        <span class="textareaRequiredMsg">Maklumat diperlukan.</span>
                        <span class="textareaMaxCharsMsg">Melibihi jumlah huruf yang dibenarkan.</span>
                        <div class="padb"><textarea name="ids_detail" id="ids_detail" cols="45" rows="5"></textarea></div>
                        <div>
                        <div class="fl w70">
                        <input name="MM_insert" type="hidden" id="MM_insert" value="formIdeas" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Hantar" /> 
                        <input name="batal" type="button" class="cancelbutton" id="batal" value="Batal" onClick="toggleview2('formIdeas'); return false;" /> 
                        </div>
                        <div class="fr padr"><span id="countdetail">&nbsp;</span>&nbsp;<span>huruf</span></div>
                        </div>
                        </td>
                      </tr>
                      <tr>
                        <td colspan="2" class="noline txt_size2">Dengan klik butang 'Hantar' bermaksud anda bersetuju dengan syarat dan peraturan dan bertanggungjawab terhadap apa yang dinyatakan. Ideas hanya boleh dihantar satu (1) kali sahaja setiap hari dan terhad kepada 300 huruf sahaja.</td>
                      </tr>
                    </table>
                  </form>
                  </span>
                </li>
                </div>
                <?php }; ?>
                <?php if(countAllIdeasID(0, $m, $y, $typeid)>0){?>
                <?php foreach(getAllIdeasID(0, $m, $y, $typeid, 0, $ob) AS $id_key => $id_value){?>
                <li class="line_b on">
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="top" class="noline txt_line" style="width: 150px;">
                      <div class="padt">
                        <div style="text-align:center; width: 100%" class="txt_line">
                        <?php if(!checkUserVoteByIdeasID($row_user['user_stafid'], $id_value) && checkExpiredByIdeasID($id_value)){?>
                          <form id="form2" name="form2" method="post" action="../sb/add_ideassupport.php">
                          	<input name="MM_insert" type="hidden" id="MM_insert" value="formIdeasSupport" />
                          	<input name="ids_id" type="hidden" id="ids_id" value="<?php echo $id_value;?>" />
                          	<input name="button4" type="submit" class="submitbutton" id="button4" value="Undi" />
                            <div class="inputlabel2"><?php echo countExpiredByIdeasID($id_value);?> hari lagi</div>
                          </form>
                        <?php } else { ?>
                      	<div>
                        <span class="txt_icon"><?php echo getPercentageUserVoteByIdeasID($id_value);?></span>
                        <span>%</span>
                        </div>
                        <div class="inputlabel2"><?php echo countAllIdeasSupportByIdeasID($id_value);?></div>
                        <div class="inputlabel2 padb">Menyokong</div>
                        <?php }; ?>
                        </div>
                      </div>
                      </td>
                      <td class="noline txt_line">
					  <div class="padb"><?php echo getIdeasDetailByID($id_value);?></div>
                      <div class="inputlabel2"><?php echo getIdeasTypeNameByID(getIdeasTypeByIdeasID($id_value));?> &nbsp; &bull; &nbsp; <?php echo getIdeasDateByID($id_value);?></div>
                      </td>
                    </tr>
                  </table>
                </li>
                <?php }; ?>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td align="center" valign="middle"><?php echo countAllIdeasID(0, $m, $y, $typeid);?> rekod dijumpai</td>
                    </tr>
                  </table>
                </li>
                <?php } else { ?>
                <li>
                <div class="note">Tiada rekod dijumpai</div>
                </li>
                <?php }; ?>
            </ul>
            </div>
        </div>
        </div>
        
		<?php include('../inc/footer.php');?>
    </div>
</div>
<script type="text/javascript">
var sprytextarea1 = new Spry.Widget.ValidationTextarea("detail", {counterId:"countdetail", counterType:"chars_remaining", maxChars:300});
</script>
</body>
</html>
<?php include('../inc/footinc.php');?> 