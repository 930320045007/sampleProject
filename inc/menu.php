<?php if(isset($_SESSION['user_stafid']) && isset($menu) && $menu!=0){?>
<?php 
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menu1 = "SELECT * FROM menu WHERE menutype_id = 1 AND menu_status = '1' ORDER BY menu_sortby ASC, menu_id ASC";
$menu1 = mysql_query($query_menu1, $hrmsdb) or die(mysql_error());
$row_menu1 = mysql_fetch_assoc($menu1);
$totalRows_menu1 = mysql_num_rows($menu1);
?>
<?php 
$wsql = "";
//if(checkJob2($row_user['user_stafid'])) // untuk modul unit sahaja kepada ketua
	$wsql = " OR menu_id = '7'";

mysql_select_db($database_hrmsdb, $hrmsdb);
$query_smenu2 = "SELECT * FROM menu WHERE EXISTS (SELECT * FROM user_sysacc WHERE menu_status = '1' AND menu.menu_id = user_sysacc.menu_id AND user_stafid = '" . $row_user['user_stafid'] . "' AND usersysacc_status = 1) AND menutype_id = 2 " . $wsql . " ORDER BY menu_sortby ASC";
$smenu2 = mysql_query($query_smenu2, $hrmsdb) or die(mysql_error());
$row_smenu2 = mysql_fetch_assoc($smenu2);
$totalRows_smenu2 = mysql_num_rows($smenu2);
?>

<div class="menu">
        	<div class="menu1">
            	<ul>
                	<?php do { ?>
                      <?php if($row_menu1['menu_url']!=NULL){?><a href="<?php echo $url_main . $row_menu1['menu_url']; ?>"><?php }; ?>
                      <li <?php if($row_menu1['menu_id']==$menu) echo "class=\"on\"";?>><?php if($row_menu1['menu_icon']!=NULL) echo " <img src=" . $url_main . $row_menu1['menu_icon'] . " border=\"0\" /> "; else echo $row_menu1['menu_name']; ?></li>
	          <?php if($row_menu1['menu_url']!=NULL){?></a><?php }; ?>
                	  <?php } while ($row_menu1 = mysql_fetch_assoc($menu1)); ?>
                </ul>
                
                <?php if ($totalRows_smenu2 == 1){ ?>
                  <ul class="ad fr">
                  	<a href="<?php echo $url_main . $row_smenu2['menu_url']; ?>">
                    <li><?php if($row_smenu2['menu_icon']!=NULL) echo " <img src=" . $url_main . $row_smenu2['menu_icon'] . " border=\"0\" />  &nbsp; "; elseif($row_smenu2['menu_id']==7) echo strtoupper(getDirTypeNameByDirTypeID(getDirTypeByDirID(getDirIDByUser($row_user['user_stafid'])))); else echo strtoupper($row_smenu2['menu_name']); ?></li>
                    </a>
                  </ul>
              <?php } elseif ($totalRows_smenu2 > 0) { // Show if recordset not empty ?>
      <?php /* <ul class="ad fr">
				<div class="tooltipContent" id="sprytooltip<?php echo $row_smenu2['menu_id'];?>"><?php if($row_smenu2['menu_id']==7) echo strtoupper(getDirTypeNameByDirTypeID(getDirTypeByDirID(getDirIDByUser($row_user['user_stafid'])))); else echo strtoupper($row_smenu2['menu_name']); ?></div>
				<a href="<?php echo $url_main . $row_smenu2['menu_url']; ?>">
                  <li id="sprytrigger<?php echo $row_smenu2['menu_id'];?>" <?php if($row_smenu2['menu_id']==$menu) echo "class=\"on\"";?>><?php if($row_smenu2['menu_icon']!=NULL) echo " <img src=" . $url_main . $row_smenu2['menu_icon'] . " border=\"0\" /> "; elseif($row_smenu2['menu_id']==7) echo getDirTypeNameByDirTypeID(getDirTypeByDirID(getDirIDByUser($row_user['user_stafid']))); else echo $row_smenu2['menu_name']; ?></li>
                  </a>
				<script type="text/javascript">
                var sprytooltip1 = new Spry.Widget.Tooltip("sprytooltip<?php echo $row_smenu2['menu_id'];?>", "#sprytrigger<?php echo $row_smenu2['menu_id'];?>");
                </script>
                  <?php } while ($row_smenu2 = mysql_fetch_assoc($smenu2)); ?>
              </ul> */ ?>
              <ul class="ad fr">
              	<li><span onclick="toggleview2('adsubmenu'); return false;">&#9660;</span>
              	  <ul id="adsubmenu" class="adsub hidden2">
               		<?php do { ?>
                    	<a href="<?php echo $url_main . $row_smenu2['menu_url']; ?>">
                        <li><?php if($row_smenu2['menu_icon']!=NULL) echo " <img src=" . $url_main . $row_smenu2['menu_icon'] . " border=\"0\" />  &nbsp; ";?><?php if($row_smenu2['menu_id']==7) echo strtoupper(getDirTypeNameByDirTypeID(getDirTypeByDirID(getDirIDByUser($row_user['user_stafid'])))); else echo strtoupper($row_smenu2['menu_name']); ?></li>
                        </a>
					<?php } while ($row_smenu2 = mysql_fetch_assoc($smenu2)); ?>
                    </ul>
                </li>
              </ul>
<?php
mysql_free_result($menu1);

mysql_free_result($smenu2);
?>
<?php };?>
</div>
</div>
<?php }; ?>
