<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuHR = "SELECT * FROM submenu WHERE menu_id = 4 AND submenu_status = '1' ORDER BY submenu_sortby ASC";
$menuHR = mysql_query($query_menuHR, $hrmsdb) or die(mysql_error());
$row_menuHR = mysql_fetch_assoc($menuHR);
$totalRows_menuHR = mysql_num_rows($menuHR);
?>
<div class="tab">
    <ul>
        <?php do { ?>
    	<li <?php if($menu2==$row_menuHR['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuHR['submenu_url']; ?>"><?php echo $row_menuHR['submenu_name']; ?></a></li>
        <?php } while ($row_menuHR = mysql_fetch_assoc($menuHR)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuHR);
?>