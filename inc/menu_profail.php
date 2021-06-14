<?php
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuprofile = "SELECT * FROM submenu WHERE menu_id = 1 AND submenu_status = '1' ORDER BY menu_id ASC";
$menuprofile = mysql_query($query_menuprofile, $hrmsdb) or die(mysql_error());
$row_menuprofile = mysql_fetch_assoc($menuprofile);
$totalRows_menuprofile = mysql_num_rows($menuprofile);
?>

<div class="tab">
    <ul>
        <?php do { ?>
        <li <?php if($menu2==$row_menuprofile['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuprofile['submenu_url']; ?>"><?php echo $row_menuprofile['submenu_name']; ?></a></li>
          <?php } while ($row_menuprofile = mysql_fetch_assoc($menuprofile)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuprofile);
?>
