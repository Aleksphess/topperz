<?
$userID=(int)$_GET['userID'];
$itemID=(int)$_GET['itemID'];
$name=addslashes($_GET['name']);

if ($itemID>0 && $userID>0)
{
	if (file_exists("connect.php")) include("connect.php"); else include("../includes/connect.php");


	$rowi=FetchID($TABLE_CATALOG,$add);
	$qi="INSERT INTO `$TABLE_SERV_ITEMS` (`id` ,`userID`,`itemID`,`name_1`,`crtdate`) VALUES (NULL , '$userID', '$itemID', '$name', '".date("U")."')";
	mQuery($qi);
	echo $qi.mError();
	
	$query="SELECT * FROM $TABLE_SERV_ITEMS ORDER BY id desc";
	$result = mQuery($query);
	$rows=mFetchArray($result);
	echo '<script>document.location=\'http://voda.com.ua/admin/items.php?tabler=&tablei=serv_items&id='.$rows['id'].'#header\'</script>';
	if (file_exists("disconnect.php")) include("disconnect.php"); else include("../includes/disconnect.php"); 
}
?>

