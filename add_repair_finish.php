<?php
session_start();
include "config.php"; 

$pagename = 'add_repair_finish.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'xtgjxtv';
$dbname = 'db_auto';

    $connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Could not connect to host ...");	
    mysql_select_db($dbname) or die ("Could not select database student ...");

	if($_GET[order_num] && $_GET[date] )
	{
		$_SESSION['order_num'] = $_GET[order_num];
		$query = "INSERT INTO repair (order_num, organization, date, description,  license_num, gang_num, id_acceptor, VIN)  VALUES (";
		$query .= "'".$_GET[order_num]."'," ;
		$query .="'no', ";
		$query .="'".$_GET[date]."',"  ;
		$query .="'".$_GET[info]."',"  ;
		$query .="'".$_GET[driver]."',"  ;
		$query .="'".$_GET[gang]."',"  ;
		$query .="'".$_GET[acc]."',"  ;
		$query .="'".$_GET[auto]."')";
		
		$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	}
	
?>


<html>
<head>
	
    <meta http-equiv="refresh" content="8;/index.php">
	<link href="/css/style.css" rel="stylesheet" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
</head>

<body>
	<div id="Body">
		<center>Запись о ремонте успешно добавлена. Через 8 секунд вас вернет на главную страницу. Если этого не произошло нажмите <a href="/index.php">сюда</a></center>
	</div>

</body>
