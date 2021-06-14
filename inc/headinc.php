<script type="text/javascript" src="<?php echo $url_main;?>js/all.js"></script>
<script type="text/javascript" src="<?php echo $url_main;?>editor/ckeditor.js"></script>
<script src="<?php echo $url_main;?>SpryAssets/SpryTooltip.js" type="text/javascript"></script>
<link href="<?php echo $url_main;?>SpryAssets/SpryTooltip.css" rel="stylesheet" type="text/css" />

<title><?php echo $systitle_short;?> <?php if(isset($_SESSION['user_stafid'])) echo " : " . strtoupper(getFullNameByStafID($_SESSION['user_stafid'])); ?></title>