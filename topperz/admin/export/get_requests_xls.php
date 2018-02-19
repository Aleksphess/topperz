<?php

require("lib/excel_writer.php");

if (isset($_GET['table'])){
    $table = $_GET['table'];
}
else 
{
    $table = 'feedbacks';
}

//if ($table == 'sale_obj') {
//	if ($_GET['vud_prv'] == 1) {
//		$fp = "small";
//		$wh = "AND obj_privat_type = 1";
//	} else {
//		$fp = "big";
//		$wh = "AND obj_privat_type = 2";
//	}
//    
//      if (!empty($_SESSION['admin']['region']) && $_SESSION['admin']['region'] > 0) {
//			$wh .= " AND region = " . $_SESSION['admin']['region'];
//    }
//}
//elseif ($table == 'rent_obj') {
//    
//    if (!empty($_SESSION['admin']['region']) && $_SESSION['admin']['region'] > 0) {
//			$wh = "AND region = " . $_SESSION['admin']['region'];
//    }
//}
//elseif (!empty($_GET['new']) && $table == 'requests') {
//	$fp = "new";
//	$wh = "AND processed = 0";
//} 
//elseif (!empty($_GET['new']) && $table == 'pgu_requests') {
//	$fp = "new";
//	$wh = "AND processed = 0";
//} 
//else {
//	$fp = "all";
//	$wh = '';
//}
//if ($table == 'file_docs') {
//	if ($_GET['cons'] == 1) {
//		$fp = "cons";
//		$wh = "AND category_id = 37";
//	} 
//}

if (!isset(${"admin_$table"})) {
    $fcn = "admin_$table";
    ${"admin_$table"} = new $fcn();
}

$fname=$table.'_'.date('Y-m-d');
@unlink('tmp/'.$fname);
$excel = new ExcelWriter("tmp/$fname.xls");
   
    if($excel==false)   
        echo $excel->error;
    
//    $types = array(0,1,2,6,7,9,13,16);
    $fields = array(); 
    $fieldsNames = array(); 
    foreach(${"admin_$table"}->fld as $fld)	{
//  if (in_array($fld->type, $types)) {
        if($table == 'orders' && (($fld->name == 'items') || ($fld->name == 'paybox_link'))) {
            continue;
        }
        
        $fields[] = $fld->name;
        $fieldsObj[] = $fld;
        $fieldsK[] = '`'.$fld->name.'`';
        $fieldsNames[] = iconv('utf-8','windows-1251',$fld->txt);
//  }

    }
	
    $excel->writeLine($fieldsNames);


$q = "SELECT ".implode(',', $fieldsK)."
FROM $table WHERE 1 ORDER BY id DESC";

$res = mQuery($q);
$num = mNumRows($res);
$sum = 0;

for($i=0;$i<$num;$i++)
{
    $row = mFetchAssoc($res);
    $fn = 0;
    foreach ($fields as $f) {
		
        if($f == 'creation_time' || $f == 'update_time') 
        {
            $row[$f] = gmdate('Y-m-d H:m:s', $row[$f]);   
        }
        
        if ($fieldsObj[$fn]->type == 9) {
            $row_assoc_item = FetchID($fieldsObj[$fn]->table_val,$row[$fieldsObj[$fn]->name]);
            $row[$f] = isset($row_assoc_item[$fieldsObj[$fn]->table_field]) ? $row_assoc_item[$fieldsObj[$fn]->table_field]:$row_assoc_item[$fieldsObj[$fn]->table_field . '_1'];
        }        
        
        $row[$f] = strip_tags(iconv('utf-8','windows-1251',stripslashes($row[$f])));

        $fn++;
    }
	
    $excel->writeLine($row);
}

$excel->close();
echo '<strong><a href="/admin/tmp/'.$fname.'.xls">Загрузить таблицу</a></strong>';