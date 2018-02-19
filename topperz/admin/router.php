<?php
if (floatval(phpversion()) < 5.1) {
    die('PHP must be 5.1+ version!');
}

require_once("config.php");
require_once("inc/Connect.php");
require_once("inc/Defines.php");
require_once("inc/CommonFuncs.php");


if (!isset($SESSIONS_PROVIDER)) {
    session_start();
}
else {
    require_once($SESSIONS_PROVIDER);
}


/*Автолоадер моделей*/
$d = scandir("models/");
foreach($d as $file) {
	if (($file != '..') && ($file != '.') && (strstr(strtolower($file),".php") !== FALSE)) {
		require_once("models/" . $file);
	}
}


if (isset($_GET['inc']) && $_GET['inc'] != '' && $_GET['inc'] != 'login') {
	$sttime = getTime();
    
    //var_dump($_SESSION);
    
	$admin_name = isset($_SESSION['admin_name'])?$_SESSION['admin_name']:'';
	$admin_id = isset($_SESSION['admin_id'])?$_SESSION['admin_id']:NULL;
	
	
	
	//Anti self loop
    if ($_GET['inc'] == 'router') {
        $_GET['inc'] = "index";
    }
    
	//echo '$inc='.$_GET['inc'];
    
    // Login check
	if ($ADMIN_SESSION_AUTH == 1) {
		//var_dump($_SESSION);
		if (!isset($_SESSION['admin_name']) || (isset($_SESSION['admin_name']) && $_SESSION['admin_name']== '')) {
			
            if ($_SERVER['REQUEST_URI'] != '/admin/') 
                $backUrl = '?backUrl=' . base64_encode($_SERVER['REQUEST_URI']);
            else
                $backUrl = '';
            
			die('<script>document.location=\'/admin/login.php' . $backUrl . '\'</script>');
		}
	}
	else {
        $admin_name = $_SERVER['REMOTE_USER'];
    }
	if (!empty($_REQUEST['tabler'])) {
		
		$cfn = 'admin_' . $_REQUEST['tabler'];
		${'admin_' . $_REQUEST['tabler']} = new $cfn();
	}

	if (!empty($_REQUEST['tablei'])) {
		
		$cfn = 'admin_' . $_REQUEST['tablei'];
		${'admin_' . $_REQUEST['tablei']} = new $cfn();
	}
	
	if (!empty($_REQUEST['table'])) {
		
		$cfn = 'admin_' . $_REQUEST['table'];
	
		if (class_exists($cfn)) {
			${'admin_' . $_REQUEST['table']} = new $cfn();
		}
	}

	if (is_file($_GET['inc'].'.php')) {
		include($_GET['inc'].'.php');
	}
	elseif (is_file('controllers/' . $_GET['inc'].'.php')) {
		include('controllers/' . $_GET['inc'].'.php');
	}
	else {
		die('File not found!');
	}
}
else {
    include('controllers/login.php');
}
