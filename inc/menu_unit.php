<?php
$wsql = "";
if(checkJob2($row_user['user_stafid'])) // untuk modul unit sahaja kepada ketua
{
	$wsql .= " OR submenu_id = '19' OR submenu_id = '77'";
} else {
	$wsql .= " AND submenu_id != '19' AND submenu_id != '77'";
};
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_menuUN = "SELECT * FROM www.submenu WHERE menu_id = 7 AND submenu_status = '1' " . $wsql . " ORDER BY submenu_sortby ASC";
$menuUN = mysql_query($query_menuUN, $hrmsdb) or die(mysql_error());
$row_menuUN = mysql_fetch_assoc($menuUN);
$totalRows_menuUN = mysql_num_rows($menuUN);
?>
<div class="tab">
    <ul>
        <?php do { ?>
    	<li <?php if($menu2==$row_menuUN['submenu_id']) echo "class=\"ontab\"";?>><a href="<?php echo $url_main . $row_menuUN['submenu_url']; ?>"><?php echo $row_menuUN['submenu_name']; ?></a></li>
        <?php } while ($row_menuUN = mysql_fetch_assoc($menuUN)); ?>
    </ul>
</div>
<?php
mysql_free_result($menuUN);
?>
