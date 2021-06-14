<?php
 require_once('../Connections/hrmsdb.php'); 

 	// $user_stafid='P2568';
	// $userdependents_relation='3';

	$user_stafid=$_POST['user_stafid'];
	$userdependents_relation=$_POST['userdependents_relation'];
	$column=$_POST['column'];
	$query_ss = "SELECT * FROM www.user_dependents WHERE user_stafid = '".$user_stafid."' AND userdependents_relation = '".$userdependents_relation."' AND userdependents_status = '1'";

	$dir_ss = mysql_query($query_ss) or die(mysql_error());

	// $alldependent = mysql_fetch_assoc($dir_ss);

	while ($row = mysql_fetch_assoc($dir_ss)) {
		
		$userdependents_id=$row['userdependents_id'];
		$userdependents_name=$row['userdependents_name'];
		$userdependents_ic=$row['userdependents_ic'];

		if($column=='userdependents_name'){
    		echo "<option value='$userdependents_name'>".$userdependents_name."</option>";
		}
    	if($column=='userdependents_ic'){
    		echo "<option value='$userdependents_ic'>".$userdependents_ic."</option>";
		}
	}

	
?>