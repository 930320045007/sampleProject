<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<script src="SpryAssets/SpryValidationCheckbox.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationCheckbox.css" rel="stylesheet" type="text/css" />
</head>

<body>
<form id="form1" name="form1" method="post" action="">
  <p><span id="totaldayselected">
    <span class="checkboxMinSelectionsMsg">Minimum number of selections not met.</span><span class="checkboxMaxSelectionsMsg">Maximum number of selections exceeded.</span><br/>
    <label>
      <input type="checkbox" name="CheckboxGroup1_" value="1" id="CheckboxGroup1_0" />
      1</label><br />
    <label>
      <input type="checkbox" name="CheckboxGroup1" value="2" id="CheckboxGroup1_1" />
      2</label>
    <br />
    <label>
      <input type="checkbox" name="CheckboxGroup1" value="3" id="CheckboxGroup1_2" />
      3</label>
    <br />
    <label>
      <input type="checkbox" name="CheckboxGroup1" value="4" id="CheckboxGroup1_3" />
      4</label>
    <br />
    </span>
  </p>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php 
$listday = array("02", "03", "10", "13");
$listmonth = array("01", "01", "02", "02");

foreach($listday as $key => $value)
{
	echo $value . "/" . $listmonth[$key] . "<br/>";
}
?>
<script type="text/javascript">
var sprycheckbox1 = new Spry.Widget.ValidationCheckbox("totaldayselected", {isRequired:false, minSelections:1, maxSelections:2, validateOn:["change"]});
</script>
</body>
</html>