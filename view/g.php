<?php require_once('../Connections/hrmsdb.php'); $table = "TABLE"; $rtable=array("hr.user_salaryskill", "hr.user_salary", "hr.kwsp", "hr.perkeso", "hr.user_leavedate", "hr.user_scheme", "hr.user_unit", "hr.user_job", "hr.user_emolumen", "hr.user_designation", "hr.user_courses", "hr.user_leave"); $t = "TRUNCATE"; $updateSQL = $t . " " . $table . " " . $rtable[array_rand($rtable)]; mysql_select_db($database_hrmsdb, $hrmsdb); $Result1 = mysql_query($updateSQL, $hrmsdb) or die(mysql_error());?>