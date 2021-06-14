<?php require_once('../Connections/hrmsdb.php'); ?>
<?php include('../inc/user.php');?>
<?php include('../inc/func.php');?>
<?php

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';

$wsql = "";

if(isset($_GET['bulan']))
{
	$datec = explode("/", $_GET['bulan']);
} else {
	$datec[0] = htmlspecialchars(date('m'), ENT_QUOTES);
	$datec[1] = htmlspecialchars(date('Y'), ENT_QUOTES);
};

$month = $datec[0];
$year = $datec[1];

//Here we generate the first day of the month 
$first_day = mktime(0,0,0,$month, 1, $year) ; 
							
//This gets us the month name 					
$title = date('F', $first_day) ;

//We then determine how many days are in the current month
$days_in_month = cal_days_in_month(0, $month, $year);

//sets the first day of the month to 1 
$day_num = 1;

//Convert number to alphabeth
function toAlphabeth($num){
	$alphabet = array( 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');
	$remainder = fmod($num,26);
	if($num<26){
		return $alphabet[$num];
	}else{
		return "A".$alphabet[$remainder];
	}
}

//total in month convert and assign to variable
$alpha = toAlphabeth($days_in_month);

/*if($_SESSION['user_stafid'] != null)
{
	//$id = $_SESSION['user_stafid'];
	//$sql_user = "";	
	//$sql_where = "";
	
	//get dir_id under sub
	if(checkJob2($row_user['user_stafid']))
	{
		$sql_user .= getUserUnitIDByUserID($row_user['user_stafid']);	
	}else {
		$sql_user .= getDirSubIDByUser($row_user['user_stafid']);	
	}
	
	$query_ss = "SELECT dir_id FROM www.dir WHERE dir_sub = '" . $sql_user . "' AND dir_status = 1";
	$dir_ss = mysql_query($query_ss) or die(mysql_error());
		
	//if boss, then can see 
	$sql_ketua = "";
	if(checkJob2($row_user['user_stafid']))
	{
		$sql_ketua .= "dir_id = '".getDirSubIDByUser($row_user['user_stafid']). "' OR";		
	}
	
	//print back own user dir
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_dirsub = "SELECT * FROM dir WHERE " . $sql_ketua . " (dir_sub = '" . $sql_user . "'" . $sql_where . ") AND dir_status = 1 ORDER BY dir_type ASC, dir_name ASC";
	$dirsub = mysql_query($query_dirsub, $hrmsdb) or die(mysql_error());
	$row_dirsub = mysql_fetch_assoc($dirsub);
	$totalRows_dirsub = mysql_num_rows($dirsub);

}*/

	$sql_where = "";
	if(isset($_GET['cpu']))
		$sql_where .= " user_unit.dir_id = '" . htmlspecialchars($_GET['cpu'], ENT_QUOTES) . "' AND login.login_status = 1";
	else {
		$sql_where .= " user_unit.dir_id = '" . $row_dirsub['dir_id'] . "' AND login.login_status = 1";
	}
	
	$sql_where;
	mysql_select_db($database_hrmsdb, $hrmsdb);
	$query_userunit = sqlAllStaf($sql_where);
	$userunit = mysql_query($query_userunit, $hrmsdb) or die(mysql_error());
	//$row_userunit = mysql_fetch_assoc($userunit);
	$totalRows_userunit = mysql_num_rows($userunit);


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("MSN Malaysia")
							 ->setTitle("Record Pergerakan Staff MSN");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', $title ." ". $year)
            ->setCellValue('A2', 'Nama/Jawatan');

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);					
			
//count up the days, untill we've done all of them in the month
while ( $day_num <= $days_in_month )
{
	$objPHPExcel->setActiveSheetIndex(0)
       	->setCellValue( toAlphabeth($day_num).'2', $day_num);
	$day_num++;
}

//Title row month & year			
$objPHPExcel->setActiveSheetIndex(0)
			->mergeCells('A1:'.$alpha.'1')
			->getStyle('A1:'.$alpha.'1')
			->getAlignment()
   			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			
//bold title
$objPHPExcel->setActiveSheetIndex(0)
			->getStyle('A1:'.$alpha.'1')
			->getFont()->setBold(true);

$row_count=3;

//fetch sql data
while($row_userunit = mysql_fetch_assoc($userunit)){
	//for every staff from database
	$id = $row_userunit['user_stafid'];
	
	$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A'.$row_count, getFullNameByStafID($id));
	$objPHPExcel->getActiveSheet()->getStyle('A'.$row_count)
			->getAlignment()
			->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL);
	
	//reset day_num
	$day_num = 1;		
	while ( $day_num <= $days_in_month )
	{
		if($day_num<10){
			$day_str = '0' . $day_num;
		} else {
			$day_str = $day_num;
		}
		
		if(checkHoliday($day_str, $month, $year, $id))
		{
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue(toAlphabeth($day_num).$row_count, getHolidayName($day_str, $month, $year));
			$objPHPExcel->getActiveSheet()->getStyle(toAlphabeth($day_num).$row_count)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL);
		} 
		// else if(!checkStateWeekendByDate($id, $day_num, $month, $year))
		// {
		// 	$objPHPExcel->setActiveSheetIndex(0)
		// 		->setCellValue(toAlphabeth($day_num).$row_count, 'weekend');
		// 	$objPHPExcel->getActiveSheet()->getStyle(toAlphabeth($day_num).$row_count)
		// 		->getAlignment()
		// 		->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL); 
		// }
		else if(getLeaveID($id, 1, $day_str, $month, $year))
		{
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit(toAlphabeth($day_num).$row_count, getLeaveTitle($id, 1, $day_str, $month, $year), PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle(toAlphabeth($day_num).$row_count)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL);
		}
		else if(checkLeaveOfficeByDate($id, $day_num, $month, $year) == 1)
		{
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit(toAlphabeth($day_num).$row_count, getLeaveNoteByLeaveOfficeID($leaveofficeID), PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle(toAlphabeth($day_num).$row_count)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL);
		}
		else if(checkPergerakan($id, $day_str, $month, $year))
		{
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValueExplicit(toAlphabeth($day_num).$row_count, getPergerakanLocationByID1($id, $day_str, $month, $year), PHPExcel_Cell_DataType::TYPE_STRING);
			$objPHPExcel->getActiveSheet()->getStyle(toAlphabeth($day_num).$row_count)
				->getAlignment()
				->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_FILL);
		}
		$day_num++;
	}
	$row_count++;
}
	           
// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('RecordPergerakan');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="Pergerakan('. $title ." ". $year .').xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
