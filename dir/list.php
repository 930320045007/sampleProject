<?
//set IE read from page only not read from cache
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

header("content-type: application/x-javascript; charset=tis-620");
?>
<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php
if(isset($_GET['type']) && $_GET['type']=='17')
{
	$stype = htmlspecialchars($_GET['val'], ENT_QUOTES);
	
	if($stype == 1)
	{
		//bahagian
		$query_dir = "SELECT dir.dir_id FROM www.dir WHERE dir_status = 1 ORDER BY  dir_id ASC, dir_sort ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir); 
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"unit\" id=\"unit\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		

		
	} elseif ($stype == 2)
	{
		//nama
		echo "<input name=\"n\" type=\"text\" class=\"w30\" id=\"n\" />";
		
	} elseif($stype == 3)
	{
		//stafid
		echo "<input name=\"si\" type=\"text\" class=\"w30\" id=\"si\" />";
		
	} elseif($stype == 4)
	{
		//kad pengenalan
		echo "<input name=\"kp\" type=\"text\" class=\"w30\" id=\"kp\" />";
		
	} elseif($stype == 5)
	{
		//alphabet
		echo "<select name=\"c\" id=\"c\">";
		foreach(range('A', 'Z') AS $alp)
		{
			echo "<option value=\"" . $alp ."\">" . $alp . "</option>";
		};
		echo "</select>";
		
	} elseif($stype == 6)
	{
		//tahun
		echo "<select name=\"tahun\" id=\"tahun\">";
		echo "</select>";
		for($i=date('Y'); $i>=2012; $i--)
		{
			echo "<option value=" . $i . ">" .$i . "</option>";
		};
	}
	
	
		
	
	if($stype > 0)
		echo "<input name=\"button4\" type=\"submit\" class=\"submitbutton\" id=\"button4\" value=\"Semak\" />";
};
?>

