<ul class="funcmenu">
    <li <?php if($menu3=='2') echo "class=\"funcon\"";?>><a href="<?php echo $url_main;?>head/profil.php?sid=<?php echo $_GET['sid'];?>">Profil</a></li>
	<li <?php if($menu3=='1') echo "class=\"funcon\"";?>><a href="<?php echo $url_main;?>head/details.php?sid=<?php echo $_GET['sid'];?>">Kerjaya</a></li>
    <li <?php if($menu3=='3') echo "class=\"funcon\"";?>><a href="<?php echo $url_main;?>head/leavereport.php?sid=<?php echo $_GET['sid'];?>">Laporan Cuti</a></li>
    <li <?php if($menu3=='4') echo "class=\"funcon\"";?>><a href="<?php echo $url_main;?>head/coursesreport.php?sid=<?php echo $_GET['sid'];?>">Laporan Kursus</a></li>
</ul>