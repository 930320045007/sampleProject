<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuICT = "SELECT * FROM submenu WHERE menu_id = '18' AND submenu_status = '1' ORDER BY submenu_sortby ASC";
$menuICT = mysql_query($query_menuICT, $hrmsdb) or die(mysql_error());
$row_menuICT = mysql_fetch_assoc($menuICT);
$totalRows_menuICT = mysql_num_rows($menuICT);
?>
<div class="tab">
    <ul>
        <?php do { ?>
        <li <?php if($menu2==$row_menuICT['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuICT['submenu_url']; ?>"><?php echo $row_menuICT['submenu_name']; ?></a></li>
          <?php } while ($row_menuICT = mysql_fetch_assoc($menuICT)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuICT);
?>
