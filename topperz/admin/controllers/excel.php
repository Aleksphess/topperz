<?php
ini_set('max_execution_time', 600);
define('ROOT', realpath(__DIR__.'/../../'));
define('ADM_ROOT', realpath(__DIR__.'/../'));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $PROJECT_NAME.': '.$word[$ALANG]['adminpanel']; ?></title>
	<?php
	$App->insertHead();
	?>
	<style type="text/css">
		table td {padding:0 10px 10px 0; vertical-align:top;}
		table td, table td * {font-size:13px;}
		table td label {font-weight:bold; cursor:pointer;}
		table td input[type=checkbox], table td input[type=radio] {float:left; margin:2px 5px 0 0;}
	</style>
</head>

<body>
	<?php require_once(ADM_ROOT."/controllers/menu.php"); ?>
	<div class="container">
		<?php include(ADM_ROOT.'/inc/ExcelApp.php'); ?>
	</div>

	<?php include(ADM_ROOT."/inc/Bottom.php"); ?>
</body>
</html>