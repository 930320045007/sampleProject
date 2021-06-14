<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php  
header ("Content-Type:text/xml");  

$sql_where = " login.login_status = '1' ";
$orderby = "0";

if(isset($_GET['bhg']))
{
	$sql_where .= " AND user_unit.dir_id = '" . htmlspecialchars($_GET['bhg'], ENT_QUOTES) . "' AND userunit_status = '1' ";
	
} elseif(isset($_GET['n']))
{
	$n = htmlspecialchars($_GET['n'], ENT_QUOTES);
	$sql_where .= " AND (user.user_firstname LIKE '%" . $n . "%' OR user.user_lastname LIKE '%" . $n . "%')";
	
} else 
{
	$sql_where .= " AND user_unit.dir_id = '1' AND userunit_status = '1' ";
};
	
mysql_select_db($database_hrmsdb, $hrmsdb);
$query_staflist = sqlAllStaf($sql_where, $orderby);
$staflist = mysql_query($query_staflist, $hrmsdb) or die(mysql_error());
$row_staflist = mysql_fetch_assoc($staflist);

$totalRows_staflist = mysql_num_rows($staflist);
?>
<?php 
echo "<staflist>";

if($totalRows_staflist > 0)
{
	do {
		echo "<staf>";
			echo "<id>" . htmlspecialchars($row_staflist['user_stafid'], ENT_QUOTES) . "</id>";
			echo "<nama>" . htmlspecialchars(getFullNameByStafID($row_staflist['user_stafid']), ENT_QUOTES) . "</nama>";
			echo "<jawatan>";
			if(getCitizenByUserID($row_staflist['user_stafid'])=='130') 
				echo htmlspecialchars(getJobtitle($row_staflist['user_stafid']), ENT_QUOTES);
			echo "</jawatan>";
			echo "<dir>" . htmlspecialchars(getFulldirectoryByUserID($row_staflist['user_stafid']), ENT_QUOTES) . "</dir>";
			echo "<email>" . htmlspecialchars(getEmailISNByUserID($row_staflist['user_stafid'],1), ENT_QUOTES) . "</email>";
			echo "<ext>" . htmlspecialchars(getExtNoByUserID($row_staflist['user_stafid'],0), ENT_QUOTES) . "</ext>";
			echo "<simg>" . htmlspecialchars(getProfilePic($row_staflist['user_stafid']), ENT_QUOTES) . "</simg>";
		echo "</staf>";
	}while($row_staflist = mysql_fetch_assoc($staflist));
};

echo "</staflist>";

mysql_free_result($staflist);
?>
