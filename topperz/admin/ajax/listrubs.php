<?
header("Pragma: no-cache");
header('Cache-Control: no-cache');

if (file_exists("connect.php")) include("connect.php"); else include("../includes/connect.php");

${"admin_$tabler"}->SORT=str_replace("%20"," ",${"admin_$tabler"}->SORT);

if (isset(${"admin_$tabler"}->ECHO_NAME)) $echo_rub_name=${"admin_$tabler"}->ECHO_NAME;
else $echo_rub_name="name_1";

$under2pos=null;
$i=0;
while(${"admin_$tablei"}->fld[$i]->name) 
{
	if (${"admin_$tablei"}->fld[$i]->name=="under2") $under2pos=$i;
	$i++;
}

if (isset(${'admin_'.$tablei}->ALT_ID)) $idname=${'admin_'.$tablei}->ALT_ID;
else $idname='id';

if (isset(${"admin_$tablei"}->TABLE_RUB_ASSOC) && $id>0)
{
	
	if ($_GET['addrub']>0 && $id>0 && !($tablei==$tabler && $id==$_GET['addrub']))
	{
		mQuery("INSERT INTO ".${"admin_$tablei"}->TABLE_RUB_ASSOC." VALUES ('".$id."','".$_GET['addrub']."')");
		//echo mError();
	}
	if ($_GET['delrub']>0 && $id>0)
	{
		mQuery("DELETE FROM ".${"admin_$tablei"}->TABLE_RUB_ASSOC." WHERE under=".$_GET['delrub']." AND recID=".$id."");
	}
}

$tdbg="";//"bgcolor=\"#c6d1de\"";
echo "<table border=0 class=txt>";
if ($tabler!="")
{	
	if ($under>0) 
	{
		$query="SELECT * FROM $tabler WHERE `id`='$under' ORDER BY ".${"admin_$tabler"}->SORT." LIMIT 50";
		//echo $query;
		$result = mQuery($query);
		$row=mFetchArray($result);
		echo "<tr $tdbg><td align=center>".imedm."</td><td><b><font color=#ff0000>".stripslashes($row[$echo_rub_name])."</font></b></td><td width=45></td></tr>";
		echo "<tr $tdbg><td align=center>".imfolder1."</td><td><a href=\"javascript:ListRubs($row[under],0,0)\"><b>/..</b></a></td><td></td><td width=45></td></tr>";
		}
	else echo "<tr $tdbg><td align=center>".imedm."</td><td><b><font color=#ff0000>".$word[$ALANG]['root']."</font></b></td><td width=45></td></tr>";

	if ($under) $query="SELECT * FROM $tabler WHERE `under`='$under' ORDER BY ".${"admin_$tabler"}->SORT." LIMIT 100";
	//echo $query;
	$result = mQuery($query);
	$num=mNumRows($result);
	if ($num) for ($i=0; $i<$num;$i++)
		{
		$row=mFetchArray($result);
		$row[name]=stripslashes($row[name]);
		$row[name_1]=stripslashes($row[name_1]);
		$row[zag_1]=stripslashes($row[zag_1]);
		$queryp="SELECT * FROM ".${"admin_$tablei"}->TABLE_RUB_ASSOC." WHERE `recID`='$id' AND under=$row[id]";
		//echo $queryp;
		$resultp = mQuery($queryp);
		$nump=mNumRows($resultp);
		if ($nump>0) $plus="";
		else $plus="<strong><a href=\"javascript:ListRubs($row[under],$row[id],0)\">+</a></strong>";
		
		echo "<tr $tdbg><td align=center>".imfolder1."</td><td><a href=\"javascript:ListRubs($row[id],0,0)\">$row[$echo_rub_name]</a></td><td>#$row[id]</td><td width=45>$plus</td><td width=45></td></tr>";
		}
}

//echo $_GET['addrub'].' '.${"admin_$tablei"}->TABLE_RUB_ASSOC.' '.$id;

if (isset(${"admin_$tablei"}->TABLE_RUB_ASSOC) && $id>0)
{
	echo "<tr $tdbg><td align=center></td><td><hr></td><td></td><td width=45></td><td width=45></td></tr>";
	$query="SELECT $tabler.*,admin_assoc.under as rubID FROM ".${"admin_$tablei"}->TABLE_RUB_ASSOC." as admin_assoc LEFT JOIN $tabler ON  ($tabler.id=admin_assoc.under) WHERE admin_assoc.recID=$id ORDER by id";
	//echo $query;
	$result = mQuery($query);
	$num=mNumRows($result);
	if ($num) for ($i=0; $i<$num;$i++)
		{
		$row=mFetchArray($result);
		$row[$echo_rub_name]=stripslashes($row[$echo_rub_name]);
		
		if ($row['under']>0) $row[$echo_rub_name]=RubName($tabler,$row['under']).' / '.$row[$echo_rub_name];
		//var_dump($row);
		echo "<tr $tdbg><td align=center>".imfolder1."</td><td><a href=\"javascript:ListRubs($row[id],0,0)\"><strong>$row[$echo_rub_name]</strong></a></td><td>#$row[id]</td><td width=45><strong><a href=\"javascript:ListRubs($under,0,$row[rubID])\">-</a></strong></td><td width=45></td></tr>";
		}
}
echo "</table>";
if (file_exists("disconnect.php")) include("disconnect.php"); else include("../includes/disconnect.php");
?>

