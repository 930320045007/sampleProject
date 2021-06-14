<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuMBJ = "SELECT * FROM submenu WHERE menu_id = '" . htmlspecialchars($menu, ENT_QUOTES) . "' AND submenu_status = '1' ORDER BY submenu_sortby ASC";
$menuMBJ = mysql_query($query_menuMBJ, $hrmsdb) or die(mysql_error());
$row_menuMBJ = mysql_fetch_assoc($menuMBJ);
$totalRows_menuMBJ = mysql_num_rows($menuMBJ);
?>
<div class="tab">
    <ul>
        <?php do { ?>
        <?php if(checkUserSysAcc($row_user['user_stafid'], $menu, $row_menuMBJ['submenu_id'], 1)){?>
        <li <?php if($menu2==$row_menuMBJ['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuMBJ['submenu_url']; ?>"><?php echo $row_menuMBJ['submenu_name']; ?></a></li>
        <?php }; ?>
          <?php } while ($row_menuMBJ = mysql_fetch_assoc($menuMBJ)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuMBJ);
?>
