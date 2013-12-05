
<?php

include "config.php"; 

$pagename = 'add_repair.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'xtgjxtv';
$dbname = 'db_auto';
/*
$query = "SELECT 	order_num, date, 
					driver.name, repair.license_num, 
					repair.gang_num, gang.specialization,
					auto.model, auto.state_number, repair.VIN 
			FROM repair
				JOIN auto 		ON repair.VIN = auto.VIN
				JOIN driver 	ON repair.license_num = driver.license_num
				JOIN gang		ON repair.gang_num = gang.gang_num
		";


$srch_collect = array("№ заказ-наряда" => "order_num",
						"Дата(гггг-мм-дд)" => "date",
						"ФИО" => "name",
						"№ Вод.удостоверения" => "license_num",
						"№ Бригады" => "gang_num",
						"Специализация бригады" => "specialization",
		//				"Id приемщика" => "id_acceptor",
		//				"ФИО приемщика" => "acceptor_name",
						"Марка(модель)" => "model",
						"Гос.номер" => "state_number",
						"VIN" => "VIN");
$srch_sql = array("order_num" => "order_num",
						"date" => "date",
						"name" => "driver.name",
						"license_num" => "repair.license_num",
						"gang_num" => "repair.gang_num",
						"specialization" => "gang.specialization",
						"model" => "auto.model",
						"state_number" => "auto.state_number",
						"VIN" => "repair.VIN");

*/
    $connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Could not connect to host ...");	
    mysql_select_db($dbname) or die ("Could not select database student ...");
/*
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line1[] = mysql_fetch_array($result, MYSQL_ASSOC))

	
	$page = intval($page);
//	echo 'page='.$page.'<br>';
//	echo 'total='.$total.'<br>';
	if(empty($page) or $page < 0) $page = 1;
		if($page > $total) $page = $total;
//	echo 'num='.$num.'<br>';
//	echo 'page='.$page.'<br>';
//	echo 'start='.$start.'<br>';
	$start = $page * $num - $num;
	if($start < 0)
		$start = 0;
	$qr_limit = " LIMIT $start,$num";
	if($_GET[group_by])
		$qr_group = " GROUP BY ".$_GET[group_by];
	else
		$qr_group = "";
		echo $_SERVER['REQUEST_URI'].'<br>';
	echo $query.$qr_group.$qr_limit;
	*/ 

	
?>


<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
	
	<style>
	html, body{
margin:3;
padding:10;
}/* отступы и поля элементовhtmlиbody равны нулю*/
#Link{width: 700px;}
#Box{
	background-color: #ffff00;
	width: 700px;  /*width: 700  - ширинаблокаBoxравна 700 пикселей  */
        border: 1px dotted; /* Пунктирнаярамка */
	margin:0avto;}  /*margin:0  -отступы Блока Box сверху и снизу равны нулю*/   
#SubBox{
	height: 470px;
	background-color: #000000;
	margin:0avto;}  /*margin:0  -отступы Блока Box сверху и снизу равны нулю*/   

#Sort {
	
	background-color: #ff9900;
	float:left;
	width:250px;
	height: 100%;
	}

#Info {
	background-color: #0099cc;
	float:right;
	width:450px;	
	height: 100%;
	}
	
#LeftSide {
	
	background-color: #ff9900;
	float:left;
	width:350px;
	height: 100%;
	}

#RightSide{
	background-color: #0099cc;
	float:right;
	width:350px;	
	height: 100%;
	}

#Footer {
	background-color: #e1e1e1;	
	clear:left;	
	}

	table
	{
		border-collapse:collapse;
	}
	table,th, td
	{
		border: 1px solid black;
	}
	</style>
	<link href="/css/style.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<form name = "edit_and_view" action = "script/request.php" method = "get">
<div id="Link"> 
<a href="/index.php">Назад</a>
</div>

<div id="Box">
<div id="SubBox">
<!-- ====================LeftSide====================-->
<div id="LeftSide">
	Номер заказ-наряда:
		<input type = "text" width = 10 name = "order_num" value = "">
	
<br>
	Дата:
	<input type = "text" name = "date" value = "">	
<br>
	Автомобиль:
	<?php  
	$query ="SELECT model, VIN FROM auto";
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC))
	?>
	<select name = "auto">
	<?php  	
	foreach ($line as $l)
	{
	 echo "<option value = '$l[model]'>$l[model]";
	 
	}	
		?>
    </select>
<br>
	Водитель:
	<?php  
	$query ="SELECT name, license_num FROM driver";
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line2[] = mysql_fetch_array($result, MYSQL_ASSOC))
	?>
	<select name = "driver">
	<?php  	
	foreach ($line2 as $l)
	{
	 echo "<option value = '$l[license_num]'>$l[name]";
	 
	}	
		?>
    </select>
<br>		
	Бригада:
	<?php  
	$query ="SELECT specialization, gang_num FROM gang";
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line3[] = mysql_fetch_array($result, MYSQL_ASSOC))
	?>
	<select name = "gang">
	<?php  	
	foreach ($line3 as $l)
	{
	 echo "<option value = '$l[gang_num]'>$l[specialization]";
	}	
	?>
    </select>	
<br>
	Приемщик: 
	<?php  
	$query ="SELECT name, id_acceptor FROM acceptor";
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line4[] = mysql_fetch_array($result, MYSQL_ASSOC))
	?>
	<select name = "acc">
	<?php  	
	foreach ($line4 as $l)
	{
	 echo "<option value = '$l[id_acceptor]'>$l[name]";
	}	
	?>
    </select>	
<br>	
<br>
	Запчасти:<br>
	<select name = "parts" size=10>
	
    </select>	
	<br>
		<?php  
		$query ="SELECT name, parts_num FROM spares";
		$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
		while ($line5[] = mysql_fetch_array($result, MYSQL_ASSOC))
		?>
		<select name = "spares">
		<?php  	
		foreach ($line5 as $l)
		{
		 echo "<option value = '$l[parts_num]'>$l[name]";
		}	
		?>	
		</select>
	<br>
	<input type = "button" name = "add_pinlist" value = "Добавить запчасть в список">
</div>
<!-- ================================================-->
<!-- ====================RightSide===================-->
<div id="RightSide">
	Описание:<br>
	<textarea name = "info" rows = "10" cols = "40">
	
	</textarea>
<br>
	Работы:<br>
	<select name = "works" size=10>
	
    </select>	
	<br>
		<?php  
		$query ="SELECT name, work_num FROM work";
		$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
		while ($line6[] = mysql_fetch_array($result, MYSQL_ASSOC))
		?>
		<select name = "work_list">
		<?php  	
		foreach ($line6 as $l)
		{
		 echo "<option value = '$l[work_num]'>$l[name]";
		}	
		?>	
		</select>
	<br>
	<input type = "button" name = "add_winlist" value = "Добавить работу в список">
</div>
</div>
<!-- ================================================-->
<!-- ==========Кнопка добавить запись================-->
<div id="Footer">
	<center>
		<input type = "submit" value = "Добавить запись">
	</center>	
</div>
<!-- ================================================-->
</div>
</body>
</html>
