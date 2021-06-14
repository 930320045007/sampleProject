<?
//set IE read from page only not read from cache
header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header ("Cache-Control: no-cache, must-revalidate");
header ("Pragma: no-cache");

header("content-type: application/x-javascript; charset=tis-620");
?>
<form id="form1" name="form1" method="post" action="pergerakan.php">
<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/func.php');?>
<?php 
mysql_select_db($database_hrmsdb, $hrmsdb);
if(isset($_GET['type']) && $_GET['type']=='17')
{
	
	$stype = htmlspecialchars($_GET['val'], ENT_QUOTES);
	


	if($stype == 1)
	{
		//bahagian
		$query_dir = "SELECT * FROM dir LEFT JOIN dir_type ON dir.dir_id = dir_type.dirtype_id WHERE dir_status = '1'  AND dir_sub = '82' ORDER BY 			dirtype_id ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
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
		
	} elseif ($stype == 8)
	{
		//Pusat
		$query_dir = "SELECT * FROM dir LEFT JOIN dir_type ON dir.dir_id = dir_type.dirtype_id WHERE (dir_status = '1' AND dir_sub = '118' OR dir_sub = '143' OR dir_sub = '122' OR dir_sub = '147' OR dir_sub = '148') AND NOT dir_id = '136' OR dir_id = '137' ORDER BY dirtype_id ASC, dir_name ASC";

		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 9)
	{
		//Jabatan
		$query_dir = "SELECT * FROM dir LEFT JOIN dir_type ON dir.dir_id = dir_type.dirtype_id WHERE dir_status = '1'  AND dir_sub = '126' OR dir_sub = '130' ORDER BY 	dirtype_id ASC, dir_name ASC";

		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 10)
	{
		//Cawangan
		$query_dir = "SELECT * FROM dir LEFT JOIN dir_type ON dir.dir_id = dir_type.dirtype_id WHERE dir_status = '1'  AND dir_id = '136' ORDER BY 			dirtype_id ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 11)
	{
		//cpu
		$query_dir = "SELECT * FROM dir LEFT JOIN dir_type ON dir.dir_id = dir_type.dirtype_id WHERE dir_status = '1'  AND dir_sub = '137' ORDER BY 			dirtype_id ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 12)
	{
		//Pejabat
		$query_dir = "SELECT * FROM dir LEFT JOIN dir_type ON dir.dir_id = dir_type.dirtype_id WHERE dir_status = '1' AND NOT dir_name = \"Direktorat\"  AND NOT dir_name = \"Anti Doping\" AND dir_sub = '1' ORDER BY dirtype_id ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 13)
	{
		//Kementerian
		$query_dir = "SELECT dir.dir_id FROM www.dir WHERE dir_type=6 AND dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 14)
	{
		//Seksyen
		$query_dir = "SELECT dir.dir_id FROM www.dir WHERE dir_type=7 AND dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif ($stype == 15)
	/*{
		//Pakar
		$query_dir = "SELECT dir.dir_id FROM www.dir WHERE dir_type=8 AND dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
		$dir = mysql_query($query_dir, $hrmsdb) or die(mysql_error());
		$row_dir = mysql_fetch_assoc($dir);
		$total = mysql_num_rows($dir);
		
		echo "<select name=\"cpu\" id=\"cpu\">";
		
		do{
			echo "<option value=\"" . $row_dir['dir_id'] . "\">" . getFulldirectory($row_dir['dir_id'], 0) . "</option>";
		}while($row_dir = mysql_fetch_assoc($dir));
		
		echo "</select>";
		
	} elseif($stype == 6)*/
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
		echo "<input name=\"button3\" type=\"submit\" class=\"submitbutton\" id=\"button3\" value=\"Semak\" />";

// }
// }
};

?>

