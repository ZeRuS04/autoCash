<?php
session_start();

include "config.php"; 

$pagename = 'add_repair.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'xtgjxtv';
$dbname = 'db_auto';

    $connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Could not connect to host ...");	
    mysql_select_db($dbname) or die ("Could not select database student ...");	
		$query ="SELECT * FROM repair WHERE order_num = $_GET[order_num]";
		$result = mysql_query($query) or die('query has dont work: ' . mysql_error());	
		while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC))
		
		$order_num = $line[0]['order_num'];
		$date = $line[0]['date'];
		$description = $line[0]['description'];
		$license_num = $line[0]['license_num'];
		$gang_num = $line[0]['gang_num'];
		$id_acceptor = $line[0]['id_acceptor'];
		$VIN = $line[0]['VIN'];
	
?>
<html>
<head>
	<script type="text/javascript" src="/jq/jquery.js"></script>
	<style>
		table
	{
		width: 900;
		border-collapse:collapse;
	}
		table, tr
	{
		border: 1px solid black;
	}
	</style>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
</head>

<body>
		<table>
			<tr>
				<td>
					<b>Номер заказ-наряда:</b>
				</td>
				<td>
					<?php echo $order_num?>
				</td>
				<td>
					<b>Дата заказ-наряда:</b>
				</td>
				<td>
					<?php echo $date?>
				</td>
			</tr>
			<tr>
				<td>
					<b>Автомобиль(VIN-номер):</b>
				</td>
				<td>
					<?php echo $VIN?>
				</td>
				<td>
					<b>Водитель(номер вод.уд):</b>
				</td>
				<td>
					<?php echo $license_num?>
				</td>
			</tr>
				<tr>
				<td>
					<b>Номер бригады:</b>
				</td>
				<td>
					<?php echo $gang_num?>
				</td>
				<td>
					<b>ID приемщика:</b>
				</td>
				<td>
					<?php echo $id_acceptor?>
				</td>
			</tr>
	<tr>
	<td colspan='4'>
		<center><b>Описание ремонта</b></center>
	</td>
	</tr>
	<tr>
	<td colspan='4'>
		<?php echo $description?>
	</td>
	</tr>
	</table>
	<script>
	window.onload = function(){
  window.print();
};
	</script>
</body>
