<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='26';?>
<?php

mysql_select_db($database_ictdb, $ictdb);
$query_cat = "SELECT * FROM ict.category";
$cat = mysql_query($query_cat, $ictdb) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);

$currentPage = $_SERVER["PHP_SELF"];

$maxRows_item = 100;
$pageNum_item = 0;
if (isset($_GET['pageNum_item'])) {
  $pageNum_item = htmlspecialchars($_GET['pageNum_item'], ENT_QUOTES);
}

$startRow_item = $pageNum_item * $maxRows_item;

if(isset($_POST['subcatid'])){
	$wsql = " AND subcategory_id = '" . htmlspecialchars($_POST['subcatid'], ENT_QUOTES) . "'";
	$subcat = htmlspecialchars($_POST['subcatid'], ENT_QUOTES);
} else {
	$wsql = " AND subcategory_id = '1'";
	$subcat = "1";
}
if(isset($_POST['item_isnsiri'])){
	$wsql = " AND (item_isnsirihi = '". $_POST['item_isnsirihi']."' AND item_isnsiriyear = '". $_POST['item_isnsiriyear']."') AND (item_isnsiri LIKE '". $_POST['item_isnsiri']."%' OR item_nosiri LIKE '". $_POST['item_isnsiri']."%')";
}
$colname_item = "-1";
if (isset($_POST['catid'])) {
	if($_POST['catid'] == 'isn'){
	  $colname_item = null;
	} else {
	  $colname_item = "AND category_id ='". htmlspecialchars($_POST['catid'], ENT_QUOTES)."'";
  	}
} else {
	$colname_item = "AND category_id ='1'";
}

mysql_select_db($database_ictdb, $ictdb);
$query_item = "SELECT * FROM ict.item WHERE item_status = '1' ". $colname_item ." ". $wsql . " ORDER BY brand_id DESC";
$query_limit_item = sprintf("%s LIMIT %d, %d", $query_item, $startRow_item, $maxRows_item);
$item = mysql_query($query_limit_item, $ictdb) or die(mysql_error());
$row_item = mysql_fetch_assoc($item);

if (isset($_GET['totalRows_item'])) {
  $totalRows_item = htmlspecialchars($_GET['totalRows_item'], ENT_QUOTES);
} else {
  $all_item = mysql_query($query_item);
  $totalRows_item = mysql_num_rows($all_item);
}
$totalPages_item = ceil($totalRows_item/$maxRows_item)-1;

$queryString_item = "";
if (!empty($_SERVER['QUERY_STRING'])) {
  $params = explode("&", $_SERVER['QUERY_STRING']);
  $newParams = array();
  foreach ($params as $param) {
    if (stristr($param, "pageNum_item") == false && 
        stristr($param, "totalRows_item") == false) {
      array_push($newParams, $param);
    }
  }
  if (count($newParams) != 0) {
    $queryString_item = "&" . htmlentities(implode("&", $newParams));
  }
}
$queryString_item = sprintf("&totalRows_item=%d%s", $totalRows_item, $queryString_item);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/liload.php');?>
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
            	  <form id="form1" name="form1" method="post" action="item.php">
            	    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                   	  <!--<tr>
                        <td nowrap="nowrap" class="label noline">Jenis Carian</td>
            	        <td width="100%" class="noline">
                          <select name="SiriISN" id="SiriISN">
                        	<option value="0">Sila Pilih Jenis Carian</option>
                            <option value="1">Kategori</option>
                            <option value="2">No Siri ISN</option>
                          </select>
                        </td>
            	        <td align="right" valign="middle" class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onClick="MM_goToURL('parent','itemadd.php');return document.MM_returnValue" /></td>
            	        <td align="right" valign="middle" class="noline"><input name="button5" type="button" class="submitbutton" id="button5" value="Penyelenggaraan" /></td>
                        </td>
                      </tr>-->
            	      <tr>
            	        <td nowrap="nowrap" class="label noline">Kategori</td>
            	        <td width="100%" class="noline">
            	          <select name="catid" id="catid" onChange="if(this.value == 'isn'){ isnSelected(); } else { resetDefault(); dochange('5', 'subcatid', this.value, '0'); }">
           	                <option value="0">Sila Pilih Kategori</option>
                            <option value="isn" id="isn">No Siri MSN</option>
            	            <?php
							do {  
							?>
							<option value="<?php echo $row_cat['category_id']?>"><?php echo $row_cat['category_name']?></option>
														<?php
							} while ($row_cat = mysql_fetch_assoc($cat));
							  $rows = mysql_num_rows($cat);
							  if($rows > 0) {
								  mysql_data_seek($cat, 0);
								  $row_cat = mysql_fetch_assoc($cat);
							  }
							?>
                          </select>
           	              <div id="subCategory">
                          <select name="subcatid" id="subcatid">
           	                <option value="0">Sila Pilih Kategori</option>
       	                  </select>
                          </div>
       	                <input name="button4" type="submit" class="submitbutton" id="button4" value="Semak" /></td>
            	        <td align="right" valign="middle" class="noline"><input name="button3" type="button" class="submitbutton" id="button3" value="Tambah" onClick="MM_goToURL('parent','itemadd.php');return document.MM_returnValue" /></td>
            	        <td align="right" valign="middle" class="noline"><input name="button5" type="button" class="submitbutton" id="button5" value="Penyelenggaraan" onClick="MM_goToURL('parent','.php');return document.MM_returnValue" /></td>
          	          </tr>
          	      </table>
          	      </form>
            	</li>
                <li>
                <div class="note">Senarai item kategori <strong><?php echo getItemCategoryByID($colname_item);?><?php if($subcat!=0) echo " > " . getItemSubCategoryByID($subcat);?></strong> </div>
 			 	<table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <?php if ($totalRows_item > 0) { // Show if recordset not empty ?>
                    <tr>
                      <th align="center" valign="middle">Bil</th>
                      <th align="left" valign="middle" nowrap="nowrap">No. Siri MSN<br/>MSN/CTM/</th>
                      <th width="100%" align="left" valign="middle">Jenama / Model / No. Siri</th>
                      <th align="center" valign="middle">Hayat</th>
                      <th align="center" valign="middle">Pinjaman</th>
                      <th align="center" valign="middle">Penama</th>
                      <th>&nbsp;</th>
                    </tr>
                    <?php $i=1; do { ?>
                      <tr class="on">
                        <td align="center" valign="middle"><?php echo $i;?></td>
                        <td align="left" valign="middle" nowrap="nowrap"><?php echo getItemISNSiriByID($row_item['item_id']); ?></td>
                        <td align="left" valign="middle"><a href="itemdetail.php?id=<?php echo $row_item['item_id']; ?>"><?php echo getItemBrandNameByID($row_item['brand_id']);?> <?php echo $row_item['item_model']; ?> &nbsp; &bull; &nbsp; <?php echo $row_item['item_nosiri']; ?></a><br/></td>
                        <td align="center" valign="middle" nowrap="nowrap"><?php $hayat = getExpireByItemID($row_item['item_id']); if($hayat['0']!=0) echo $hayat['0'] . "T "; if($hayat['1']!=0) echo $hayat['1'] . "B";?></td>
                        <td align="center" valign="middle"><?php iconICTBorrowByItemID($row_item['item_id']); ?></td>
                        <td align="center" valign="middle"><?php iconItemAvailableByItemID($row_item['item_id']);?></td>
                        <td><ul class="func"><li><a onclick="return confirm('Anda mahu maklumat berikut dipadam? \r\n\n <?php echo getItemISNSiriByID($row_item['item_id']); ?> - <?php echo getItemBrandNameByID($row_item['brand_id']);?> <?php echo $row_item['item_model']; ?>')" href="<?php echo $url_main;?>sb/del_item.php?id=<?php echo $row_item['item_id'];?>">X</a></li></ul></td>
                      </tr>
                      <?php $i++; } while ($row_item = mysql_fetch_assoc($item)); ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="noline txt_color1"><ul class="func">
                        <?php if ($pageNum_item > 0) { // Show if not first page ?>
                          <li><a href="<?php printf("%s?pageNum_item=%d%s", $currentPage, max(0, $pageNum_item - 1), $queryString_item); ?>">Prev</a></li>
                          <?php } // Show if not first page ?>
<li><?php echo $totalRows_item ?> rekod dijumpai</li>
<?php if ($pageNum_item < $totalPages_item) { // Show if not last page ?>
  <li><a href="<?php printf("%s?pageNum_item=%d%s", $currentPage, min($totalPages_item, $pageNum_item + 1), $queryString_item); ?>">Next</a></li>
  <?php } // Show if not last page ?>
                      </ul></td>
                    </tr>
                  <?php } else { ?>
                    <tr>
                      <td colspan="7" align="center" valign="middle" class="noline">Tiada rekod dijumpai</td>
                    </tr>
                    <?php }; ?>
                  </table>
                </li>
                    <?php } else { ?>
                        <li>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr>
                            <td align="center" class="noline"><?php echo noteError(1);?></td>
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
<script>
function isnSelected(){
	document.getElementById("subCategory").innerHTML = '<select name="item_isnsirihi" id="item_isnsirihi"><option value="H">Harta Modal</option><option value="I">Inventori</option></select><span class="inputlabel">/</span><select name="item_isnsiriyear" id="item_isnsiriyear"><?php for($m=(date('Y')-10); $m<=date('Y'); $m++){?><option value="<?php echo $m;?>" <?php if($m==date('Y')) echo "selected=\"selected\"";?>><?php echo $m;?></option><?php }; ?></select><span class="inputlabel">/</span><label for="item_isnsiri"></label><input name="item_isnsiri" type="text" class="w10" id="item_isnsiri"  onkeypress="return handleEnter(this, event)"/></span>';
}

function resetDefault(){
	document.getElementById("subCategory").innerHTML = '<select name="subcatid" id="subcatid"><option value="0">Sila Pilih Kategori</option></select>';
}
</script>
</body>
</html>
<?php
mysql_free_result($cat);

mysql_free_result($item);
?>
<?php include('../inc/footinc.php');?> 