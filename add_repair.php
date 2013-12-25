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
	if(isset($_SESSION['p_array']))
	{
		$p_array = $_SESSION['p_array'];
		foreach($p_array as $a)
		{
			echo $a;
		}
	}
	if($_GET[order_num])
	{
		$query_full = "INSERT INTO repair (order_num, organization, date, description,  license_num, gang_num, id_acceptor, VIN)  VALUES (";
		$query_full .= "'".$_GET[order_num]."'," ;
		$query_full .="'no', ";
		$query_full .="'".$_GET[date]."',"  ;
		$query_full .="'".$_GET[info]."',"  ;
		$query_full .="'".$_GET[driver]."',"  ;
		$query_full .="'".$_GET[gang]."',"  ;
		$query_full .="'".$_GET[acc]."',"  ;
		$query_full .="'".$_GET[auto]."')";
		echo $query_full."<br>";
	}
	elseif($_SESSION[order_num])
	{
		$query_full = "INSERT INTO repair (order_num, organization, date, description,  license_num, gang_num, id_acceptor, VIN)  VALUES (";
		$query_full .= "'".$_SESSION['order_num']."'," ;
		$query_full .="'no', ";
		$query_full .="'".$_SESSION['date']."',"  ;
		$query_full .="'".$_SESSION['info']."',"  ;
		$query_full .="'".$_SESSION['driver']."',"  ;
		$query_full .="'".$_SESSION['gang']."',"  ;
		$query_full .="'".$_SESSION['acc']."',"  ;
		$query_full .="'".$_SESSION['auto']."')";
		echo $query_full."<br>";
	}
/*	if(isset($_GET[next]))
	{
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=add_repair_next.php?order_num=$_GET[order_num]&date=$_GET[date]&info=$_GET[info]&driver=$_GET[driver]&auto=$_GET[auto]&gang=$_GET[gang]&acc=$_GET[acc]' >";
		//$result = mysql_query($query_full) or die('query has dont work: ' . mysql_error());
	}*/
	if(isset($_GET[add]))
	{
		echo "<META HTTP-EQUIV='Refresh' CONTENT='0; URL=add_repair_finish.php?order_num=$_GET[order_num]&date=$_GET[date]&info=$_GET[info]&driver=$_GET[driver]&auto=$_GET[auto]&gang=$_GET[gang]&acc=$_GET[acc]' >";
		//$result = mysql_query($query_full) or die('query has dont work: ' . mysql_error());
	}
	if(isset($_GET[clear]))
	{
		unset($_SESSION['order_num']);
		unset($_GET[order_num]);
		unset($_SESSION['date']);
		unset($_GET[date]);
		unset($_SESSION['auto']);
		unset($_GET[auto]);
		unset($_SESSION['driver']);
		unset($_GET[driver]);
		unset($_SESSION['gang']);
		unset($_GET[gang]);
		unset($_SESSION['acc']);
		unset($_GET[acc]);
		unset($_SESSION['info']);
		unset($_GET[info]);
		unset($_SESSION['spares']);
		unset($_GET[spares]);
		unset($_SESSION['parts']);
		unset($_GET[parts]);
	}
	
?>

<!--******************HTML****************************-->

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
		<form name = "add_rep" action = "/add_repair.php" method = "get"><input type = "submit" name ="clear" value = "Oчистить">
		<input type = "submit" name ="add" value = "Добавить">
	
	</div>
	
	<div id="Body">
		<div id="LeftSide">
			<br>
			Номер заказ-наряда:
			<?php 
			if(isset($_GET[order_num]))
			{
				echo "<input type = 'text' width = 10 name = 'order_num' value = '".$_GET[order_num]."'>";
				$_SESSION['order_num'] = $_GET[order_num];
			}
			elseif(isset($_SESSION['order_num']))
				echo "<input type = 'text' width = 10 name = 'order_num' value = '".$_SESSION['order_num']."'>";
			else
				echo "<input type = 'text' width = 10 name = 'order_num' value = ''>";
			?>
				
			
		<br>
			Дата:
			<?php 
			if(isset($_GET[date]))
			{
				echo "<input type = 'text' width = 10 name = 'date' value = '".$_GET[date]."'>";
				$_SESSION['date'] = $_GET[date];
			}
			elseif(isset($_SESSION['date']))
				echo "<input type = 'text' width = 10 name = 'date' value = '".$_SESSION['date']."'>";
			else
				echo "<input type = 'text' width = 10 name = 'date' value = ''>";
			?>
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
				
				if(isset($_GET[auto]) && ($_GET['auto'] == $l[VIN]))
				{
					$_SESSION['auto'] = $_GET[auto];
					echo "<option value = '$l[VIN]' selected>$l[model]";
				}
				elseif(isset($_SESSION['auto']) && ($_SESSION['auto'] == $l[VIN]))
				{
					echo "<option value = '$l[VIN]' selected>$l[model]";
				}
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
			<select name = "driver">
			<?php  	
			foreach ($line2 as $l)
			{
				if(isset($_GET[driver]) && ($_GET['driver'] == $l[license_num]))
				{
					$_SESSION['driver'] = $_GET[driver];
					echo "<option value = '$l[license_num]' selected>$l[name]";
				}
				elseif(isset($_SESSION['driver']) && ($_SESSION['driver'] == $l[license_num]))
				{
					echo "<option value = '$l[license_num]' selected>$l[name]";
				}
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
			<select name = "gang">
			<?php  	
			foreach ($line3 as $l)
			{		
				if(isset($_GET[gang]) && ($_GET[gang] == $l[gang_num]))
				{
					$_SESSION['gang'] = $_GET[gang];
					echo "<option value = '$l[gang_num]' selected>$l[gang_num]";
				}
				elseif(isset($_SESSION['gang']) && ($_SESSION['gang'] == $l[gang_num]))
				{
					echo "<option value = '$l[gang_num]' selected>$l[gang_num]";
				}
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
			<select name = "acc">
			<?php  	
			foreach ($line4 as $l)
			{
				if(isset($_GET[acc]) && ($_GET['acc'] == $l[id_acceptor]))
				{
					$_SESSION['acc'] = $_GET[acc];
					echo "<option value = '$l[id_acceptor]' selected>$l[name]";
				}
				elseif(isset($_SESSION['acc']) && ($_SESSION['acc'] == $l[id_acceptor]))
				{
					echo "<option value = '$l[id_acceptor]' selected>$l[name]";
				}
				else
					echo "<option value = '$l[id_acceptor]'>$l[name]";

			}	
			?>
			</select>	
		<br>

		</div>
		<!-- ================================================-->
		<!-- ====================RightSide===================-->
		<div >
			Описание:<br>
			<textarea name = "info" rows = "10" cols = "40"><?php
			if(isset($_GET[info]))
			{
				$_SESSION['info'] = $_GET[info];
				echo $_GET[info];
			}
			elseif(isset($_SESSION['info']))
				echo $_SESSION['info'];
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
