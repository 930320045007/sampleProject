<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php $menu='5';?>
<?php $menu2='8';?>
<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_marital = "SELECT * FROM marital WHERE marital_status = '1' ORDER BY marital_name ASC";
$marital = mysql_query($query_marital, $hrmsdb) or die(mysql_error());
$row_marital = mysql_fetch_assoc($marital);
$totalRows_marital = mysql_num_rows($marital);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_rel = "SELECT * FROM relationship WHERE relationship_status = '1' ORDER BY relationship_name ASC";
$rel = mysql_query($query_rel, $hrmsdb) or die(mysql_error());
$row_rel = mysql_fetch_assoc($rel);
$totalRows_rel = mysql_num_rows($rel);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_maj = "SELECT * FROM employer_type WHERE employertype_status = '1' ORDER BY employertype_name ASC";
$maj = mysql_query($query_maj, $hrmsdb) or die(mysql_error());
$row_maj = mysql_fetch_assoc($maj);
$totalRows_maj = mysql_num_rows($maj);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_edu = "SELECT * FROM edu_level WHERE edulevel_status = '1' ORDER BY edulevel_id ASC";
$edu = mysql_query($query_edu, $hrmsdb) or die(mysql_error());
$row_edu = mysql_fetch_assoc($edu);
$totalRows_edu = mysql_num_rows($edu);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_state = "SELECT * FROM `state` WHERE state_status = '1' ORDER BY state_name ASC";
$state = mysql_query($query_state, $hrmsdb) or die(mysql_error());
$row_state = mysql_fetch_assoc($state);
$totalRows_state = mysql_num_rows($state);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_loc = "SELECT * FROM location WHERE location_status = '1' ORDER BY location_name ASC";
$loc = mysql_query($query_loc, $hrmsdb) or die(mysql_error());
$row_loc = mysql_fetch_assoc($loc);
$totalRows_loc = mysql_num_rows($loc);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_bangsa = "SELECT * FROM race WHERE race_status = '1' ORDER BY race_short ASC";
$bangsa = mysql_query($query_bangsa, $hrmsdb) or die(mysql_error());
$row_bangsa = mysql_fetch_assoc($bangsa);
$totalRows_bangsa = mysql_num_rows($bangsa);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_agama = "SELECT * FROM religion WHERE religion_status = '1' ORDER BY religion_name ASC";
$agama = mysql_query($query_agama, $hrmsdb) or die(mysql_error());
$row_agama = mysql_fetch_assoc($agama);
$totalRows_agama = mysql_num_rows($agama);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_jobtype = "SELECT * FROM job_type WHERE jobtype_status = '1' ORDER BY jobtype_name ASC";
$jobtype = mysql_query($query_jobtype, $hrmsdb) or die(mysql_error());
$row_jobtype = mysql_fetch_assoc($jobtype);
$totalRows_jobtype = mysql_num_rows($jobtype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_bank = "SELECT * FROM bank ORDER BY bank_name ASC";
$bank = mysql_query($query_bank, $hrmsdb) or die(mysql_error());
$row_bank = mysql_fetch_assoc($bank);
$totalRows_bank = mysql_num_rows($bank);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kewe = "SELECT * FROM kewe WHERE kewe_status = 1 ORDER BY kewetype_id ASC";
$kewe = mysql_query($query_kewe, $hrmsdb) or die(mysql_error());
$row_kewe = mysql_fetch_assoc($kewe);
$totalRows_kewe = mysql_num_rows($kewe);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_kwtype = "SELECT * FROM kewe_type WHERE kewetype_status = 1 ORDER BY kewetype_name ASC";
$kwtype = mysql_query($query_kwtype, $hrmsdb) or die(mysql_error());
$row_kwtype = mysql_fetch_assoc($kwtype);
$totalRows_kwtype = mysql_num_rows($kwtype);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_source = "SELECT * FROM source WHERE source_status = '1' ORDER BY source_name ASC";
$source = mysql_query($query_source, $hrmsdb) or die(mysql_error());
$row_source = mysql_fetch_assoc($source);
$totalRows_source = mysql_num_rows($source);

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_property = "SELECT * FROM property_type WHERE propertytype_status = '1' ORDER BY propertytype_name ASC";
$property = mysql_query($query_property, $hrmsdb) or die(mysql_error());
$row_property = mysql_fetch_assoc($property);
$totalRows_property = mysql_num_rows($property);
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
        <?php include('../inc/menu_admin.php');?>
<div class="tabbox">
          <div class="profilemenu">
          	<ul>
              <li><div class="note">Sila lengkapkan perkara berikut</div></li>
            	<li class="title">Status Perkahwinan <span class="fr add" onclick="toggleview2('marital_form'); return false;">+ Tambah</span></li>
              <div id="marital_form" class="hidden">
          	  <li>
          	    <form id="marital_submit" name="marital_submit" method="POST" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Status</td>
          	          <td width="100%" class="noline">
       	              <input name="marital_name" type="text" class="w50" id="marital_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="marital_submit" /></td>
       	            </tr>
       	          </table>
                </form>
              </li>
              </div>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline">
                    <ul class="li2c">
                        <?php do { ?>
                          <li><span class="name"><?php echo $row_marital['marital_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_marital['marital_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?maid=<?php echo $row_marital['marital_id'];?>">&times;</a></span></li>
                          <?php } while ($row_marital = mysql_fetch_assoc($marital)); ?>
                    </ul>
                  </td>
                </tr>
              </table>
              </li>
              <li class="title">Hubungan<span class="fr add" onclick="toggleview2('rel_form'); return false;">+ Tambah</span></li>
              <div id="rel_form" class="hidden">
          	  <li>
          	    <form id="rel_submit" name="rel_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Hubungan</td>
          	          <td width="100%" class="noline">
       	              <input name="relationship_name" type="text" class="w50" id="relationship_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="rel_submit" /></td>
       	            </tr>
       	          </table>
       	        </form>
              </li>
              </div>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td class="noline">
                <ul class="li2c">
                	<?php do { ?>
                	  <li><span class="name"><?php echo $row_rel['relationship_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_rel['relationship_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?rid=<?php echo $row_rel['relationship_id'];?>">&times;</a></span></li>
                	  <?php } while ($row_rel = mysql_fetch_assoc($rel)); ?>
                </ul>
                </td>
              </tr>
            </table>
              </li>
              <li class="title">Kategori Majikan<span class="fr add" onclick="toggleview2('katmaj_form'); return false;">+ Tambah</span></li>
              <div id="katmaj_form" class="hidden">
              <li>
          	    <form id="katmaj_submit" name="katmaj_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Kategori</td>
          	          <td width="100%" class="noline">
       	              <input name="employertype_name" type="text" class="w50" id="employertype_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="katmaj_submit" /></td>
       	            </tr>
       	          </table>
       	        </form>
              </li>
              </div>
              <li><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                   	  <?php do { ?>
                   	    <li><span class="name"><?php echo $row_maj['employertype_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_maj['employertype_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?mid=<?php echo $row_maj['employertype_id'];?>">&times;</a></span></li>
                   	    <?php } while ($row_maj = mysql_fetch_assoc($maj)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </li>
                <li class="title">Tahap Pendidikan<span class="fr add" onclick="toggleview2('edu_form'); return false;">+ Tambah</span></li>
                <div class="hidden" id="edu_form">
                <li>
          	    <form id="edu_submit" name="edu_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Tahap</td>
          	          <td width="100%" class="noline">
       	              <input name="edulevel_name" type="text" class="w50" id="edulevel_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="edu_submit" /></td>
       	            </tr>
       	          </table>
       	        </form>
                </li>
                </div>
                <li>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <tr>
                    <td class="noline">
                    <ul class="li2c">
                   	  <?php do { ?>
                   	    <li><span class="name"><?php echo $row_edu['edulevel_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_edu['edulevel_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?eid=<?php echo $row_edu['edulevel_id'];?>">&times;</a></span></li>
                   	    <?php } while ($row_edu = mysql_fetch_assoc($edu)); ?>
                    </ul>
                    </td>
                  </tr>
                </table>
                </li>
                <li class="title">Lokasi Penempatan<span class="fr add" onclick="toggleview2('loc_form'); return false;">+ Tambah</span></li>
              <div id="loc_form" class="hidden">
                <li>
                  <form id="location_submit" name="location_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label">Nama Lokasi</td>
                        <td>
                        <input type="text" name="location_name" id="location_name" /></td>
                      </tr>
                      <tr>
                        <td class="label">Negeri</td>
                        <td>
                          <select name="state_id" id="state_id">
                            <?php
do {  
?>
                            <option value="<?php echo $row_state['state_id']?>"><?php echo $row_state['state_name']?></option>
                            <?php
} while ($row_state = mysql_fetch_assoc($state));
  $rows = mysql_num_rows($state);
  if($rows > 0) {
      mysql_data_seek($state, 0);
	  $row_state = mysql_fetch_assoc($state);
  }
?>
                        </select></td>
                      </tr>
                      <tr>
                        <td class="noline">&nbsp;</td>
                        <td class="noline"><input name="button2" type="submit" class="submitbutton" id="button2" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="location_submit" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
               	  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                	  <tr>
                	    <td class="noline">
                          <ul class="li2c">
                            <?php do { ?>
                              <li><span class="name"><?php echo $row_loc['location_name'] . ", " . getState($row_loc['state_id']); ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n <?php echo $row_loc['location_name']; ?>, <?php echo getState($row_loc['state_id']);?>)" href="<?php echo $url_main;?>sb/setting_admin.php?lid=<?php echo $row_loc['location_id'];?>">&times;</a></span></li>
                              <?php } while ($row_loc = mysql_fetch_assoc($loc)); ?>
                          </ul></td>
              	    </tr>
              	  </table>
                </li>
                <li class="title">Bangsa<span class="fr add" onclick="toggleview2('bang_form'); return false;">+ Tambah</span></li>
                <div id="bang_form" class="hidden">
                <li>
          	    <form id="race_submit" name="race_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Bangsa</td>
          	          <td width="100%" class="noline">
       	              <input name="race_name" type="text" class="w50" id="race_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="race_submit" /></td>
       	            </tr>
       	          </table>
       	        </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                      <ul class="li2c">
                      	<?php do { ?>
                      	  <li><span class="name"><?php echo $row_bangsa['race_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_bangsa['race_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?baid=<?php echo $row_bangsa['race_id'];?>">&times;</a></span></li>
                      	  <?php } while ($row_bangsa = mysql_fetch_assoc($bangsa)); ?>
                      </ul>
                      </td>
                    </tr>
                  </table>
                </li>
                <li class="title">Agama<span class="fr add" onclick="toggleview2('ag_form'); return false;">+ Tambah</span></li>
              <div id="ag_form" class="hidden">
                <li>
          	    <form id="ag_submit" name="ag_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Agama</td>
          	          <td width="100%" class="noline">
       	              <input name="religion_name" type="text" class="w50" id="religion_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="ag_submit" /></td>
       	            </tr>
       	          </table>
       	        </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                      <ul class="li2c">
                   	    <?php do { ?>
                   	      <li><span class="name"><?php echo $row_agama['religion_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_agama['religion_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?aid=<?php echo $row_agama['religion_id'];?>">&times;</a></span></li>
                   	      <?php } while ($row_agama = mysql_fetch_assoc($agama)); ?>
                      </ul>
                      </td>
                    </tr>
                  </table>
                </li>
                <li class="title">Status Perlantikan<span class="fr add" onclick="toggleview2('sp_form'); return false;">+ Tambah</span></li>
              <div id="sp_form" class="hidden">
                <li>
          	    <form id="sp_submit" name="sp_submit" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Status</td>
          	          <td width="100%" class="noline">
       	              <input name="jobtype_name" type="text" class="w50" id="jobtype_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="sp_submit" /></td>
       	            </tr>
       	          </table>
       	        </form>
                </li>
              </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                      <ul class="li2c">
                   	      <?php do { ?>
               	          <li><span class="name"><?php echo $row_jobtype['jobtype_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_jobtype['jobtype_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?jid=<?php echo $row_jobtype['jobtype_id'];?>">&times;</a></span></li>
                   	        <?php } while ($row_jobtype = mysql_fetch_assoc($jobtype)); ?>
                      </ul>
                      </td>
                    </tr>
                  </table>
                </li>
                <li class="title">Bank<span class="fr add" onclick="toggleview2('formbank'); return false;">+ Tambah</span></li>
                <div id="formbank" class="hidden">
                <li>
                  <form id="bank" name="bank" method="POST" action="<?php echo $url_main;?>sb/setting_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr class="noline">
                        <td class="label noline">Nama</td>
                        <td class="noline">
                        <input name="bank_name" type="text" class="w50" id="bank_name" />
                        <input name="button3" type="submit" class="submitbutton" id="button3" value="Tambah" />
                        <input type="hidden" name="MM_insert" value="bank_submit" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                        <ul class="li2c">
                            <?php do { ?>
                            <li><span class="name"><?php echo $row_bank['bank_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_bank['bank_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?bid=<?php echo $row_bank['bank_id'];?>">&times;</a></span></li>
                              <?php } while ($row_bank = mysql_fetch_assoc($bank)); ?>
                        </ul>
                     </td>
                    </tr>
                  </table>
                </li>
                <li class="title">Jenis Kew8<span class="fr add" onclick="toggleview2('formkewe'); return false;">+ Tambah</span></li>
                <div id="formkewe" class="hidden">
                <li>
                  <form id="kewe" name="kewe" method="post" action="<?php echo $url_main;?>sb/setting_admin.php">
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td class="label noline">Jenis</td>
                        <td class="noline">
                          <select name="kewetype_id" id="kewetype_id">
                            <?php
							do {  
							?>
                            <option value="<?php echo $row_kwtype['kewetype_id']?>"><?php echo $row_kwtype['kewetype_name']?></option>
                            <?php
							} while ($row_kwtype = mysql_fetch_assoc($kwtype));
							  $rows = mysql_num_rows($kwtype);
							  if($rows > 0) {
								  mysql_data_seek($kwtype, 0);
								  $row_kwtype = mysql_fetch_assoc($kwtype);
							  }
							?>
                          </select>
                        <input name="kewe_name" type="text" class="w50" id="kewe_name" />
                        <input name="button4" type="submit" class="submitbutton" id="button4" value="Tambah" />
                        <input type="hidden" name="MM_insert" value="kewe_submit" /></td>
                      </tr>
                    </table>
                  </form>
                </li>
                </div>
                <li>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0">
                    <tr>
                      <td class="noline">
                      <div class="off">
					  	<ul class="li2c">
						  <?php do { ?>
					      <li><span class="name"><?php echo getKew8TypeByID($row_kewe['kewetype_id']); ?> &nbsp; &bull; &nbsp; <?php echo $row_kewe['kewe_name']; ?></span><span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_kewe['kewe_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?kid=<?php echo $row_kewe['kewe_id'];?>">&times;</a></span></li>
						  <?php } while ($row_kewe = mysql_fetch_assoc($kewe)); ?>
                        </ul>
                        </div>
                      </td>
                    </tr>
                  </table>
                </li>
                <li class="title">Sumber Perolehan  <span class="fr add" onclick="toggleview2('source_form'); return false;">+ Tambah</span></li>
              <div id="source_form" class="hidden">
          	  <li>
          	    <form id="source" name="source" method="POST" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Sumber Perolehan</td>
          	          <td width="100%" class="noline">
       	              <input name="source_name" type="text" class="w50" id="source_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="source" /></td>
       	            </tr>
       	          </table>
                </form>
              </li>
              </div>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline">
                    <ul class="li2c">
                       <?php do { ?>
                   	    <li>
                        <span class="name"><?php echo $row_source['source_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_source['source_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?sid=<?php echo $row_source['source_id'];?>">&times;</a></span>
                        </li>
                      	<?php } while ($row_source = mysql_fetch_assoc($source)); ?>
                    </ul>
                  </td>
                </tr>
              </table>
              </li>
              <li class="title">Jenis Harta<span class="fr add" onclick="toggleview2('propertytype_form'); return false;">+ Tambah</span></li>
              <div id="propertytype_form" class="hidden">
          	  <li>
          	    <form id="propertytype" name="propertytype" method="POST" action="<?php echo $url_main;?>sb/setting_admin.php">
          	      <table width="100%" border="0" cellspacing="0" cellpadding="0">
          	        <tr>
          	          <td nowrap="nowrap" class="label noline">Jenis Harta</td>
          	          <td width="100%" class="noline">
       	              <input name="propertytype_name" type="text" class="w50" id="propertytype_name" />
       	              <input name="button" type="submit" class="submitbutton" id="button" value="Tambah" />
          	      <input type="hidden" name="MM_insert" value="propertytype" /></td>
       	            </tr>
       	          </table>
                </form>
              </li>
              </div>
              <li>
              <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                  <td class="noline">
                    <ul class="li2c">
                                               <?php do { ?>
                   	    <li>
                        <span class="name"><?php echo $row_property['propertytype_name']; ?></span>
                        <span class="del"><a onclick="return confirm('Anda mahu memadam maklumat berikut? \r\n\n<?php echo  $row_property['propertytype_name']; ?>')" href="<?php echo $url_main;?>sb/setting_admin.php?pid=<?php echo $row_property['propertytype_id'];?>">&times;</a></span> 
                        </li>

                          <?php } while ($row_property= mysql_fetch_assoc($property)); ?>
                    </ul>
                  </td>
                </tr>
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
mysql_free_result($marital);

mysql_free_result($rel);

mysql_free_result($maj);

mysql_free_result($edu);

mysql_free_result($state);

mysql_free_result($loc);

mysql_free_result($bangsa);

mysql_free_result($agama);

mysql_free_result($jobtype);

mysql_free_result($bank);

mysql_free_result($kewe);

mysql_free_result($kwtype);

mysql_free_result($source);

mysql_free_result($property);
?>
<?php include('../inc/footinc.php');?>
