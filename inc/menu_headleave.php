<?php if(isset($menu3)){?>
<ul class="funcmenu">
	<li <?php if($menu3=='1') echo "class=\"funcon\"";?>><a href="<?php echo $url_main . "head/stafleave.php";?>">Harian</a></li>
    <li <?php if($menu3=='2') echo "class=\"funcon\"";?>><a href="<?php echo $url_main . "head/stafleavemonth.php";?>">Bulanan</a></li>
    <li <?php if($menu3=='3') echo "class=\"funcon\"";?>><a href="<?php echo $url_main . "head/stafleaveyear.php";?>">Tahunan</a></li>
</ul>
<?php }; ?>