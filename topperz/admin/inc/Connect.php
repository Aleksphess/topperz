<?php
$mySqlLink = mysqli_connect($DB_HOST, $DB_USER, $DB_PASSWORD);
$db = mysqli_select_db($mySqlLink, $DB_NAME);

//Reading vars
foreach($_POST as $name => $val) {
	${$name}=$val;
}

foreach($_GET as $name => $val) {
	${$name}=$val;
}

mysqli_query($mySqlLink, "SET NAMES utf8");

try {
    $pdo = new PDO ("mysql:host=$DB_HOST;dbname=$DB_NAME;charset=utf8","$DB_USER","$DB_PASSWORD");
} catch (PDOException $e) {
    echo "Failed to get DB handle: " . $e->getMessage() . "\n";
    exit;
}
