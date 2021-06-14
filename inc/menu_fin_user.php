<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuFinance = "SELECT * FROM submenu WHERE menu_id = '" . $menu . "' AND submenu_status = '1' ORDER BY submenu_sortby ASC";
$menuFinance = mysql_query($query_menuFinance, $hrmsdb) or die(mysql_error());
$row_menuFinance = mysql_fetch_assoc($menuFinance);
$totalRows_menuFinance = mysql_num_rows($menuFinance);
?>
<div class="tab">
    <ul>
        <?php do { ?>
        <li <?php if($menu2==$row_menuFinance['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuFinance['submenu_url']; ?>"><?php echo $row_menuFinance['submenu_name']; ?></a></li>
          <?php } while ($row_menuFinance = mysql_fetch_assoc($menuFinance)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuFinance);
?>
