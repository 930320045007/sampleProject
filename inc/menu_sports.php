<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuSports = "SELECT * FROM submenu WHERE menu_id = '" . $menu . "' AND submenu_status = '1' ORDER BY submenu_sortby ASC";
$menuSports = mysql_query($query_menuSports, $hrmsdb) or die(mysql_error());
$row_menuSports = mysql_fetch_assoc($menuSports);
$totalRows_menuSports = mysql_num_rows($menuSports);
?>
<div class="tab">
    <ul>
        <?php do { ?>
        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $row_menuSports['submenu_id'], 1)){?>
        <li <?php if($menu2==$row_menuSports['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuSports['submenu_url']; ?>"><?php echo $row_menuSports['submenu_name']; ?></a></li>
        <?php }; ?>
          <?php } while ($row_menuSports = mysql_fetch_assoc($menuSports)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuSports);
?>
