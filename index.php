<?php
session_start();
include "config.php"; 

$pagename = 'index.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'xtgjxtv';
$dbname = 'db_auto';

$num = 10;

if(isset($_GET["page"]))
{
	$page = $_GET["page"];
	$_SESSION['page'] = $page;
}
elseif(isset($_SESSION['page']))
	$page = $_SESSION['page'];
	
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

function navigate($pagename, $page, $total)
{
	if($page != 1) $firstpage = '<a href= ./'.$pagename.'?page=1><<</a> <a href= ./'.$pagename.'?page='.($page - 1).'><</a> ';

	if($page != $total) $nextpage = ' <a href= ./'.$pagename.'?page='.($page + 1).'>></a>
	<a href= ./'.$pagename.'?page='.$total.'>>></a>';
	
	if($page - 2 > 0) $page2left = ' <a href= ./'.$pagename.'?page='.($page - 2).'>'.($page - 2).'</a> | ';

	if($page - 1 > 0) $pageleft = ' <a href= ./'.$pagename.'?page='.($page - 1).'>'.($page - 1).'</a> | ';

	if($page + 2 <= $total) $page2right = ' | <a href= ./'.$pagename.'?page='.($page + 2).'>'.($page + 2).'</a>';

	if($page + 1 <= $total) $pageright = ' | <a href= ./'.$pagename.'?page='.($page + 1).'>'.($page + 1).'</a> ';

	echo $firstpage.$page2left.$pageleft.'<b>'.$page.'</b>'.$pageright.$page2right.$nextpage;
}

function search($srch_collect, $srch_sql)
{
	$qr_where = " WHERE ";
	foreach($srch_collect as $k => $v)
	{
//		echo 'key = '.$k.'; value = '.$v.'; sql_value = '.$srch_sql[$v].'<br>';
		if(($_GET[$v]) && ($_GET[$v] != $k))
		{
			if(count($srch_arr) == 0)
				$srch_arr[] = $srch_sql[$v]."='".$_GET[$v]."' ";
			else
				$srch_arr[] = 'AND '.$srch_sql[$v]."='".$_GET[$v]."' ";
		}
	}

	$result = "";
	foreach($srch_arr as $i)
	{
		$result = $result.$i;
	}
	if(isset($_GET[clearbut]))
		unset($_SESSION['where']);
	if($result == "")
	{
		if(isset($_SESSION['where']))
			return $_SESSION['where'];
		else
			return "";
	}
	else
	{
		$_SESSION['where'] = $qr_where.$result;
		return $qr_where.$result;
	}
}	
    $connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Could not connect to host ...");	
    mysql_select_db($dbname) or die ("Could not select database student ...");
    
	
    $where = search($srch_collect, $srch_sql);
    $query = $query.$where;
    if($_GET[delnum])
    {
		$qr_del = "DELETE FROM parts_list WHERE order_num =".$_GET[delnum];
		$result = mysql_query($qr_del) or die('query has dont work: ' . mysql_error());
		$qr_del = "DELETE FROM repair WHERE order_num =".$_GET[delnum];
		$result = mysql_query($qr_del) or die('query has dont work: ' . mysql_error());
	}
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line1[] = mysql_fetch_array($result, MYSQL_ASSOC))
//	echo 'count line1='.count($line1).'<br>';
	$total = ((count($line1)-1)/$num)+1;
	
	$page = intval($page);
	if(empty($page) or $page < 0) $page = 1;
		if($page > $total) $page = $total;
//	echo 'num='.$num.'<br>';
//	echo 'page='.$page.'<br>';
//	echo 'start='.$start.'<br>';
	$start = $page * $num - $num;
	if($start < 0)
		$start = 0;
	$qr_limit = " LIMIT $start,$num";
	if(isset($_GET[order_by]))
		$qr_order_by = " ORDER BY ".$_GET[order_by];
	elseif(isset($_SESSION['order_by']))
		$qr_order_by = " ORDER BY ".$_SESSION['order_by'];
	else
		$qr_order_by = " ORDER BY order_num";
		
	echo $_SERVER['REQUEST_URI'].'<br>';
	echo $query.$qr_order_by.$qr_limit;
	$result = mysql_query($query.$qr_order_by.$qr_limit) or die('query has dont work: ' . mysql_error());
	while ($line[] = mysql_fetch_array($result, MYSQL_ASSOC))
	
?>


<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">	
	<style>
	table
	{
		border-collapse:collapse;
	}
	table,th, td
	{
		border: 1px solid black;
	}
	</style>
</head>
<body>
	<pre>
	<form name = "search" action = "/index.php" method = "get">
		Форма поиска: <br>
		Ремонт:		<input type = "text" name = "order_num" value = "№ заказ-наряда"  onclick="value=''">; <input type = "text" name = "date" value = "Дата(гггг-мм-дд)" onclick="value=''">;<br>
		Водитель:	<input type = "text" name = "name" value = "ФИО" onclick="value=''">; <input type = "text" name = "license_num" value = "№ Вод.удостоверения" onclick="value=''">;<br>
		Бригада: 	<input type = "text" name = "gang_num" value = "№ Бригады" onclick="value=''">; <input type = "text" name = "specialization" value = "Специализация бригады" onclick="value=''">;<br>
		Автомобиль: 	<input type = "text" name = "model" value = "Марка(модель)" onclick="value=''">; <input type = "text" name = "state_number" value = "Гос.номер" onclick="value=''">; <input type = "text" name = "VIN" value = "VIN" onclick="value=''">;<br>
		<input type = "submit" name = "search_button" value = "Поиск"></form></pre>
	<form name = "search_clr" action = "/index.php" method = "get">
		<pre>
		<input type = "submit" name = "clearbut" value = "Сбросить результаты поиска">
		</pre>
	</form>
		
	
	
	<form name = "add_repair" action = "/add_repair.php" method = "get">
		
	Добавить ремонт:	<input type = "submit" name = "add_repair" value = "Добавить">
	</form>
	<form name = "order_by" action = "/index.php" method = "get">
	<pre>
	
<?php 
	if(count($line1) < $num)
		$end = count($line)-1;
	else
		$end = $num;
	if($total > 0)
	{
		if(isset($_GET[order_by]))
		{
			$order_by = $_GET[order_by];
			$_SESSION['order_by'] = $order_by;
		}
		elseif(isset($_SESSION['order_by']))
			$order_by = $_SESSION['order_by'];
			else
				$order_by = "order_num";
		echo "Сортировать по:     <select name = 'order_by' onchange='this.form.submit()'>";
				if($order_by == "order_num" )
						echo "<option value = 'order_num' selected>№ Заказ-наряда";
					else
						echo "<option value = 'order_num'>№ Заказ-наряда";
					if($order_by == "date" )
						echo "<option value = 'date' selected>Дате";
					else
						echo "<option value = 'date'>Дате";
					if($order_by == "name" )
						echo "<option value = 'name' selected>Имени водителя";
					else
						echo "<option value = 'name'>Имени водителя";
					if($order_by == "license_num" )
						echo "<option value = 'license_num' selected>№ вод.удостоверения";
					else
						echo "<option value = 'license_num'>№ вод.удостоверения";
					if($order_by == "gang_num" )
						echo "<option value = 'gang_num' selected>№ бригады";
					else
						echo "<option value = 'gang_num'>№ бригады";
					if($order_by == "specialization" )
						echo "<option value = 'specialization' selected>Специализации";
					else
						echo "<option value = 'specialization'>Специализации";
					if($order_by == "model" )
						echo "<option value = 'model' selected>Модели автомобиля";
					else
						echo "<option value = 'model'>Модели автомобиля";
					if($order_by == "state_number" )
						echo "<option value = 'state_number' selected>Гос.номеру";
					else
						echo "<option value = 'state_number'>Гос.номеру";
					if($order_by == "VIN" )
						echo "<option value = 'VIN' selected>VIN";
					else
						echo "<option value = 'VIN'>VIN";
		echo" 	</select>
				</pre>
				</form>";
		echo "<table >\n";
		echo "	<tr>\n	
				<th>№ Заказ-наряда</th>
				<th>Дата</th>
				<th>Фио водителя</th>
				<th>№ Вод. удостоверения</th>
				<th>№ Бригады</th>
				<th>Специализация</th>
				<th>Модель автомобиля</th>
				<th>Гос.номер</th>
				<th>VIN</th>
				<th>Кнопка</th>
			</tr>\n";
	
    	echo "\t<tr>\n";

		for( $i = 0;  $i <$end; $i++)
		{
			$delnum = $line[$i]['order_num'];
			echo "
				<tr>
				<td>".$line[$i]['order_num']."</td>
				<td>".$line[$i]['date']."</td>
				<td>".$line[$i]['name']."</td>
				<td>".$line[$i]['license_num']."</td>
				<td>".$line[$i]['gang_num']."</td>
				<td>".$line[$i]['specialization']."</td>
				<td>".$line[$i]['model']."</td>
				<td>".$line[$i]['state_number']."</td>
				<td>".$line[$i]['VIN']."</td>
				<td>
				<form name = 'del' action = '/index.php' method = 'get'>
						<input type='hidden' name='delnum' value='$delnum'> 
						<input type = 'submit' width = 10 name = 'del' value = 'Удалить'>
					</form>
				</td>
				<tr>
			";
		}
		echo "</table>";
		echo '<center>';
		navigate($pagename, $page, (int)$total);
		echo '</center>';
	}
	else
		echo "Нет ни одной записи.";
?>
</body>
</html>
