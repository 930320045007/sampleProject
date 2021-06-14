<?php
//cat
function getCategoryName($id)
{
	$query_ap = "SELECT category_name FROM akta.category WHERE category_id = '" . htmlspecialchars($id, ENT_QUOTES) . "'";
	$ap = mysql_query($query_ap);
	$row_ap = mysql_fetch_assoc($ap);
	
	return $row_ap['category_name']; 
}
?>