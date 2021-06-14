<?php require_once('../Connections/hrmsdb.php'); ?>
<?php require_once('../Connections/ictdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php include('../inc/ictfunc.php');?>
<?php $menu='6';?>
<?php $menu2='32';?>
<?php
mysql_select_db($database_ictdb, $ictdb);
$query_brandl = "SELECT * FROM brand WHERE brand_status = 1 ORDER BY brand_name ASC";
$brandl = mysql_query($query_brandl, $ictdb) or die(mysql_error());
$row_brandl = mysql_fetch_assoc($brandl);
$totalRows_brandl = mysql_num_rows($brandl);

mysql_select_db($database_ictdb, $ictdb);
$query_cat = "SELECT * FROM category WHERE category_status = 1 ORDER BY category_name ASC";
$cat = mysql_query($query_cat, $ictdb) or die(mysql_error());
$row_cat = mysql_fetch_assoc($cat);
$totalRows_cat = mysql_num_rows($cat);

mysql_select_db($database_ictdb, $ictdb);
$query_ft = "SELECT * FROM feedback_type WHERE feedbacktype_status = 1 ORDER BY feedbacktype_name ASC";
$ft = mysql_query($query_ft, $ictdb) or die(mysql_error());
$row_ft = mysql_fetch_assoc($ft);
$totalRows_ft = mysql_num_rows($ft);

mysql_select_db($database_ictdb, $ictdb);
$query_itemadd = "SELECT * FROM item_add ORDER BY itemadd_name ASC";
$itemadd = mysql_query($query_itemadd, $ictdb) or die(mysql_error());
$row_itemadd = mysql_fetch_assoc($itemadd);
$totalRows_itemadd = mysql_num_rows($itemadd);

mysql_select_db($database_ictdb, $ictdb);
$query_os = "SELECT * FROM item_os ORDER BY itemos_name ASC";
$os = mysql_query($query_os, $ictdb) or die(mysql_error());
$row_os = mysql_fetch_assoc($os);
$totalRows_os = mysql_num_rows($os);

mysql_select_db($database_ictdb, $ictdb);
$query_itemram = "SELECT * FROM item_ram ORDER BY itemram_id ASC";
$itemram = mysql_query($query_itemram, $ictdb) or die(mysql_error());
$row_itemram = mysql_fetch_assoc($itemram);
$totalRows_itemram = mysql_num_rows($itemram);

mysql_select_db($database_ictdb, $ictdb);
$query_reportt = "SELECT * FROM report_type WHERE reporttype_status = 1 ORDER BY reporttype_name ASC";
$reportt = mysql_query($query_reportt, $ictdb) or die(mysql_error());
$row_reportt = mysql_fetch_assoc($reportt);
$totalRows_reportt = mysql_num_rows($reportt);

mysql_select_db($database_ictdb, $ictdb);
$query_reportst = "SELECT * FROM report_subtype WHERE reportsubtype_status = 1 ORDER BY reporttype_id ASC";
$reportst = mysql_query($query_reportst, $ictdb) or die(mysql_error());
$row_reportst = mysql_fetch_assoc($reportst);
$totalRows_reportst = mysql_num_rows($reportst);

mysql_select_db($database_ictdb, $ictdb);
$query_subcat = "SELECT * FROM subcategory ORDER BY category_id ASC";
$subcat = mysql_query($query_subcat, $ictdb) or die(mysql_error());
$row_subcat = mysql_fetch_assoc($subcat);
$totalRows_subcat = mysql_num_rows($subcat);

mysql_select_db($database_ictdb, $ictdb);
$query_vendort = "SELECT * FROM vendor_type WHERE vendortype_status = 1 ORDER BY vendortype_name ASC";
$vendort = mysql_query($query_vendort, $ictdb) or die(mysql_error());
$row_vendort = mysql_fetch_assoc($vendort);
$totalRows_vendort = mysql_num_rows($vendort);

mysql_select_db($database_ictdb, $ictdb);
$query_catlist = "SELECT * FROM category ORDER BY category_name ASC";
$catlist = mysql_query($query_catlist, $ictdb) or die(mysql_error());
$row_catlist = mysql_fetch_assoc($catlist);
$totalRows_catlist = mysql_num_rows($catlist);

mysql_select_db($database_ictdb, $ictdb);
$query_tlist = "SELECT * FROM report_type WHERE reporttype_status = 1 ORDER BY reporttype_name ASC";
$tlist = mysql_query($query_tlist, $ictdb) or die(mysql_error());
$row_tlist = mysql_fetch_assoc($tlist);
$totalRows_tlist = mysql_num_rows($tlist);

mysql_select_db($database_ictdb, $ictdb);
$query_serv = "SELECT * FROM service_type WHERE servicetype_status = 1 ORDER BY servicetype_name ASC";
$serv = mysql_query($query_serv, $ictdb) or die(mysql_error());
$row_serv = mysql_fetch_assoc($serv);
$totalRows_serv = mysql_num_rows($serv);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="../css/index.css" rel="stylesheet" type="text/css" />
<?php include('../inc/headinc.php');?>
<script type="text/javascript" src="../js/disenter.js"></script>
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
            <div class="note">Konfigurasi untuk senarai diperlukan</div>
              <li class="title">Senarai Jenama <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formbrand'); return false;">Tambah</span><?php }; ?></li>
              <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
              <div id="formbrand" class="hidden">
                <li class="form_back">
                  <form id="formbrand" name="formbrand" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Jenama</td>
                        <td class="noline"><label for="brand_name"></label>
                          <input type="hidden" name="MM_insert" value="brand" />
                          <input name="brand_name" type="text" class="w50" id="brand_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_brandl['brand_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?brandid=<?php echo $row_brandl['brand_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_brandl = mysql_fetch_assoc($brandl)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Kategori Item <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formcategori'); return false;">Tambah</span><?php }; ?></li>
              <div id="formcategori" class="hidden">
                <li class="form_back">
                  <form id="formcategory" name="formcategory" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kategori</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="category" />
                          <input name="category_name" type="text" class="w50" id="category_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_cat['category_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?categoryid=<?php echo $row_cat['category_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_cat = mysql_fetch_assoc($cat)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Sub Kategori Item <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formsubcategory'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formsubcategory" class="hidden">
                <li class="form_back">
                  <form id="formsubcategory" name="formsubcategory" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Sub Kategori</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="subcategory" />
                          <label for="category_id"></label>
                          <select name="category_id" id="category_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_catlist['category_id']?>"><?php echo $row_catlist['category_name']?></option>
                            <?php
							} while ($row_catlist = mysql_fetch_assoc($catlist));
							  $rows = mysql_num_rows($catlist);
							  if($rows > 0) {
								  mysql_data_seek($catlist, 0);
								  $row_catlist = mysql_fetch_assoc($catlist);
							  }
							?>
                          </select>
                          <input name="subcategory_name" type="text" class="w35" id="subcategory_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo getItemCategoryByID($row_subcat['category_id']) . " &nbsp; &bull; &nbsp; " . $row_subcat['subcategory_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?subcategoryid=<?php echo $row_subcat['subcategory_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_subcat = mysql_fetch_assoc($subcat)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Jenis Maklum Balas Aduan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formfeedbacktype'); return false;">Tambah</span><?php }; ?></li>
              <div id="formfeedbacktype" class="hidden">
                <li class="form_back">
                  <form id="formfeedbacktype" name="formfeedbacktype" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Jenis</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="feedbacktype" />
                          <input name="feedbacktype_name" type="text" class="w50" id="feedbacktype_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_ft['feedbacktype_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?fbtypeid=<?php echo $row_ft['feedbacktype_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_ft = mysql_fetch_assoc($ft)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Item Tambahan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formitemadd'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formitemadd" class="hidden">
                <li class="form_back">
                  <form id="formitemadd" name="formitemadd" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Item</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="itemadd" />
                          <input name="itemadd_name" type="text" class="w50" id="itemadd_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_itemadd['itemadd_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr del"><a href="../sb/add_ictsetting.php?itemaddid=<?php echo $row_itemadd['itemadd_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_itemadd = mysql_fetch_assoc($itemadd)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Sistem Operasi (OS) <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formitemos'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formitemos" class="hidden">
                <li class="form_back">
                  <form id="formitemos" name="formitemos" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Nama</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="itemos" />
                          <input name="itemos_name" type="text" class="w50" id="itemos_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_os['itemos_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?itemosid=<?php echo $row_os['itemos_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_os = mysql_fetch_assoc($os)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Kapasiti RAM <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formitemram'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formitemram" class="hidden">
                <li class="form_back">
                  <form id="formitemram" name="formitemram" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kapasiti</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="itemram" />
                          <input name="itemram_name" type="text" class="w50" id="itemram_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_itemram['itemram_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?itemramid=<?php echo $row_itemram['itemram_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_itemram = mysql_fetch_assoc($itemram)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Jenis Aduan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formreporttype'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formreporttype" class="hidden">
                <li class="form_back">
                  <form id="formreporttype" name="formreporttype" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Jenis</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="reporttype" />
                          <input name="reporttype_name" type="text" class="w50" id="reporttype_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_reportt['reporttype_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?rtid=<?php echo $row_reportt['reporttype_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_reportt = mysql_fetch_assoc($reportt)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Jenis Sub Aduan <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formreportsubtype'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formreportsubtype" class="hidden">
                <li class="form_back">
                  <form id="formreportsubtype" name="formreportsubtype" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Jenis</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="reportsubtype" />
                          <label for="reporttype_id"></label>
                          <select name="reporttype_id" id="reporttype_id">
                            <?php do { ?>
                            <option value="<?php echo $row_tlist['reporttype_id']?>"><?php echo $row_tlist['reporttype_name']?></option>
                            <?php
							} while ($row_tlist = mysql_fetch_assoc($tlist));
							  $rows = mysql_num_rows($tlist);
							  if($rows > 0) {
								  mysql_data_seek($tlist, 0);
								  $row_tlist = mysql_fetch_assoc($tlist);
							  }
							?>
                          </select>
						<input name="reportsubtype_name" type="text" class="w35" id="reportsubtype_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
              <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo getReportTypeByID($row_reportst['reporttype_id']) . " &nbsp; &bull; &nbsp; " . $row_reportst['reportsubtype_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?rstid=<?php echo $row_reportst['reportsubtype_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_reportst = mysql_fetch_assoc($reportst)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                <li class="title">Senarai Kategori Vendor <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formvendortype'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formvendortype" class="hidden">
                <li class="form_back">
                  <form id="formvendortype" name="formvendortype" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Kategori</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="vendortype" />
                          <input name="vendortype_name" type="text" class="w50" id="vendortype_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_vendort['vendortype_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?vtid=<?php echo $row_vendort['vendortype_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_vendort = mysql_fetch_assoc($vendort)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
                 <li class="title">Senarai Jenis Perkhidmatan 
                 <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?><span class="fr add" onClick="toggleview2('formservtype'); return false;">Tambah</span><?php }; ?></li>
                <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 2)){?>
                <div id="formservtype" class="hidden">
                <li class="form_back">
                  <form id="formservtype" name="formvservtype" method="POST" action="../sb/add_ictsetting.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Jenis</td>
                        <td class="noline">
                          <input type="hidden" name="MM_insert" value="servicetype" />
                          <input name="servicetype_name" type="text" class="w50" id="servicetype_name" onkeypress="return handleEnter(this, event)" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        </td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <?php }; ?>
                <li>
                <div class="off">
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                    	<?php do { ?>
                    	  <li><span class="name"><?php echo $row_serv['servicetype_name']; ?></span><?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $menu2, 4)){?><span class="fr del"><a href="../sb/add_ictsetting.php?stid=<?php echo $row_serv['servicetype_id'];?>">&times;</a></span><?php }; ?></li>
                    	<?php } while ($row_serv = mysql_fetch_assoc($serv)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </div>
                </li>
            <?php } ; ?>
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
mysql_free_result($brandl);

mysql_free_result($cat);

mysql_free_result($ft);

mysql_free_result($itemadd);

mysql_free_result($os);

mysql_free_result($itemram);

mysql_free_result($reportt);

mysql_free_result($reportst);

mysql_free_result($subcat);

mysql_free_result($vendort);

mysql_free_result($catlist);

mysql_free_result($tlist);
?>
<?php include('../inc/footinc.php');?> 