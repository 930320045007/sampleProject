<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuLV = "SELECT * FROM submenu WHERE menu_id = 3 AND submenu_status = '1' ORDER BY submenu_sortby ASC";
$menuLV = mysql_query($query_menuLV, $hrmsdb) or die(mysql_error());
$row_menuLV = mysql_fetch_assoc($menuLV);
$totalRows_menuLV = mysql_num_rows($menuLV);
?>
<div class="tab">
    <ul>
        <?php do { ?>
    	<?php if(checkSubMenuPermenant($row_user['user_stafid'], $row_menuLV['submenu_id'])){ ?>
          <li <?php if($menu2==$row_menuLV['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuLV['submenu_url']; ?>"><?php echo $row_menuLV['submenu_name']; ?></a></li>
          <?php }; ?>
        <?php } while ($row_menuLV = mysql_fetch_assoc($menuLV)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuLV);
?>