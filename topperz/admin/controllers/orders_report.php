<?php
// Report by Alex Bunke
header("Pragma: no-cache");
header('Cache-Control: no-cache');
$version = "items 23.0";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd"> 
<html dir="ltr" lang="en-US" xmlns="http://www.w3.org/1999/xhtml">

	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <?php
            $App->insertHead();
        ?>
        
        <title><?php echo $PROJECT_NAME.': '.$word[$ALANG]['adminpanel']; ?></title>

</head>

<body>
<?php 
//MENU
include("controllers/menu.php");

//Data
$reportData = [];

if (!empty($_GET['date1'])) {
    $reportData['date1'] = $_GET['date1'];
} else {
    $reportData['date1'] = date('Y-m-d');
}
if (!empty($_GET['date2'])) {
    $reportData['date2'] = $_GET['date2'];
} else {
    $reportData['date2'] = date('Y-m-d');
}
$order = new admin_orders();

$reportData['products'] = $order->getSaledProducts(['date1'=>$reportData['date1'], 'date2'=>$reportData['date2']]);

if (empty($reportData['products'])) {
    $reportData['products'][] = ['name'=>'В периоде продаж товары не найдены', 'sum'=>0, 'num'=>0];
    
}

?>
<div class="container-fluid">
        <div class="row">
            <?php
            echo $twig->render('orders_report/index.twig', $reportData);
            ?>
        </div>
 </div>
  
<?php
require_once("inc/Bottom.php");
?>
  </body>
</html>
