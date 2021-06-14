<?php require_once('Connections/hrmsdb.php'); ?>
<?php include('inc/user.php');?>
<?php include('inc/func.php');?>
<?php $menu='2';?>
<?php $menu2='36';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="css/index.css" rel="stylesheet" type="text/css" />
<?php include('inc/headinc.php');?>
</head>
<body <?php include('inc/bodyinc.php');?>>
<div>
    
	<div>
		<?php include('inc/header.php');?>
        <?php include('inc/menu.php');?>
        
      	<div class="content">
        <?php include('inc/menu_profail.php');?>
        <div class="tabbox">        	
        <?php include('inc/profile.php');?>
      <div class="profilemenu">
            <ul>
                <li class="title">Penyata Gaji Bulanan</li>
            </ul>
          </div>
          
        <!-- <iframe src="http://143.192.97.141/mypayroll/Payslip/IndividuPayslip?empno=<?=$userstafid2?>" width="100%" height="850px" frameborder="0"></iframe> -->

        <!-- <iframe src="https://galaxy.nsc.gov.my/staffportal/mp/mp_printPayslipNew?empno=<?=$userstafid2?>" width="100%" height="850px" frameborder="0"></iframe> -->
        
        </div>
        </div>
		<?php include('inc/footer.php');?>
    </div>
</div>
</body>
</html>

<?php include('inc/footinc.php');?> 