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
    if(isset($_GET[edit]))
	{
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
	}elseif(isset($_GET[save]))
	{
		$order_num = $_GET['order_num'];
		$date = $_GET['date'];
		$description = $_GET['description'];
		$license_num = $_GET['license_num'];
		$gang_num = $_GET['gang_num'];
		$id_acceptor = $_GET['id_acceptor'];
		$VIN = $_GET['VIN'];
		
		$query_save;
		$query_save ="UPDATE repair SET date= '".$date."', description='".$description."', license_num='".$license_num."',
		 gang_num='".$gang_num."', id_acceptor='".$id_acceptor."', VIN='".$VIN."' WHERE order_num = '".$order_num."'";
		$result = mysql_query($query_save) or die('query has dont work: ' . mysql_error());	
		$b = 1;
	}elseif($_GET[clear])
	{
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
	}

?>

<html>
<head>
	<script type="text/javascript" src="/jq/jquery.js"></script>
	<link href="/css/style.css" rel="stylesheet" type="text/css"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
</head>

<body>
	
	<div id="Header">
		<h2>Добавление ремонта:</h2>
	</div>
	<div id="Menu">
		<div id="Menu_search"><button>Назад</button></div>
		<form name = "save_rep" action = "/edit.php" method = "get"><input type = "submit" name ="clear" value = "Сбросить">
		<input type = "submit" name ="save" value = "Сохранить">
				<?php if($b ==1)
				echo "<font color='white'>Данные успешно сохранены</font color>";
				?>
	</div>
	
	<div id="Body">
		<div id="LeftSide">

		<br>
		
			Номер заказ-наряда:
			<?php 

				echo "<input type = 'text' readonly width = 10 name = 'order_num' value = '".$order_num."'>";
			?>
		<br>
			Дата:
			<?php 
				echo "<input type = 'text' width = 10 name = 'date' value = '".$date."'>";
			?>
		<br>
			Автомобиль:
			<?php  
			$query ="SELECT model, VIN FROM auto";
			$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
			while ($line1[] = mysql_fetch_array($result, MYSQL_ASSOC))
			?>
			<select name = "VIN">
			<?php  	
			foreach ($line1 as $l)
			{
				
				if(isset($VIN) && ($VIN == $l[VIN]))
					echo "<option value = '$l[VIN]' selected>$l[model]";
				else
					echo "<option value = '$l[VIN]'>$l[model]";
					
			 
			 
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
			<select name = "license_num">
			<?php  	
			foreach ($line2 as $l)
			{
				if(isset($license_num) && ($license_num == $l[license_num]))
					echo "<option value = '$l[license_num]' selected>$l[name]";
				else
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
			<select name = "gang_num">
			<?php
			foreach ($line3 as $l)
			{		
				if(isset($gang_num) && ($gang_num == $l[gang_num]))
					echo "<option value = '$l[gang_num]' selected>$l[gang_num]";
				else
					echo "<option value = '$l[gang_num]'>$l[gang_num]";
				
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
			<select name = "id_acceptor">
			<?php  	
			foreach ($line4 as $l)
			{
				if(isset($id_acceptor) && ($id_acceptor == $l[id_acceptor]))
					echo "<option value = '$l[id_acceptor]' selected>$l[name]";
				else
					echo "<option value = '$l[id_acceptor]'>$l[name]";

			}	
			?>
			</select>	
		<br>

		</div>
		<!-- ================================================-->
		<!-- ====================RightSide===================-->
		<div>
			Описание:<br>
			<textarea name = "description" rows = "10" cols = "40"><?php
			echo $description;
			  ?></textarea>
			<br>

		</div>
		
		
		
	</div>
	
	
<script>	
$(function(){                       // после загрузки страницы
   $('button').click(function(){// на нажатие h1 вешаем обработчик, который
     window.location.replace("/index.php");
       // у элемента с #toggler переключет видимость
   });
});
</script>
</body>

<script>	
$(function(){                       // после загрузки страницы
   $('button').click(function(){// на нажатие h1 вешаем обработчик, который
     window.location.replace("/index.php");
       // у элемента с #toggler переключет видимость
   });
});
</script>
</body>



