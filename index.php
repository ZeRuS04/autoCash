<?php
include "config.php"; 

$pagename = 'index.php';

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = 'xtgjxtv';
$dbname = 'db_auto';

$num = 10;
$page = $_GET["page"];
$query = "SELECT order_num, date, license_num, gang_num, id_acceptor, VIN FROM repair";


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

function search()
{
	$qr_where = " WHERE ";
	$qr_and = " AND ";
	
	if(($_GET["order_num"]) && ($_GET["order_num"] != "№ заказ-наряда"))
	{
		if(count($srch_arr) == 0)
			$srch_arr[] = 'order_num='.$_GET["order_num"].' ';
		else
			$srch_arr[] = 'AND order_num='.$_GET["order_num"].' ';
	}
	if(($_GET["date"]) and ($_GET["date"] != "Дата(гггг.мм.дд)"))
	{
		if(count($srch_arr) == 0)
			$srch_arr[] = "repair.date='".$_GET["date"]."' " ;
		else
			$srch_arr[] = "AND repair.date='".$_GET["date"]."' ";
	}
	$result = $qr_where;
	foreach($srch_arr as $i)
	{
		$result = $result.$i;
	}
	return $result;
}	
    $connect = mysql_connect($dbhost, $dbuser, $dbpass) or die ("Could not connect to host ...");	
    mysql_select_db($dbname) or die ("Could not select database student ...");
    $where = search();
    $query = $query.$where;
    
	$result = mysql_query($query) or die('query has dont work: ' . mysql_error());
	while ($line1[] = mysql_fetch_array($result, MYSQL_ASSOC))
	echo 'count line1='.count($line1).'<br>';
	$total = ((count($line1)-1)/$num)+1;
	
	$page = intval($page);
	echo 'page='.$page.'<br>';
	echo 'total='.$total.'<br>';
	if(empty($page) or $page < 0) $page = 1;
		if($page > $total) $page = $total;
	echo 'num='.$num.'<br>';
	echo 'page='.$page.'<br>';
	echo 'start='.$start.'<br>';
	$start = $page * $num - $num;
	$qr_limit = " LIMIT $start,$num";
	echo $query.$qr_limit;
	$result = mysql_query($query.$qr_limit) or die('query has dont work: ' . mysql_error());
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
	<form name = "search" action = "/index.php" method = "get">
	<pre>
	Форма поиска: <br>
	Ремонт:		<input type = "text" name = "order_num" value = "№ заказ-наряда">; <input type = "text" name = "date" value = "Дата(гггг.мм.дд)">;<br>
	Водитель:	<input type = "text" name = "driver_name" value = "ФИО">; <input type = "text" name = "license_num" value = "№ Вод.удостоверения">;<br>
	Бригада: 	<input type = "text" name = "<gang_name" value = "№ Бригады">; <input type = "text" name = "specialization" value = "Специализация бригады">; <input type = "text" name = "workman" value = "Исполнитель">;<br>
	Приемщик: 	<input type = "text" name = "id_acceptor" value = "Id приемщика">; <input type = "text" name = "acceptor_name" value = "ФИО приемщика">;<br>
	Автомобиль: 	<input type = "text" name = "model" value = "Марка(модель)">; <input type = "text" name = "state_number" value = "Гос.номер">; <input type = "text" name = "VIN" value = "VIN">;<br>
	<input type = "submit" name = "add_auto" value = "Поиск">
	</pre>	
	</form>
<?php
	
	echo "<table >\n";
	echo "	<tr>\n	<th>№ Заказ-наряда</th>
			<th>Дата</th>
			<th>Водитель</th>
			<th>Бригада</th>
			<th>Приемщик</th>
			<th>Автомобиль</th>
			<th>Кнопка</th>
		</tr>\n";
	
    	echo "\t<tr>\n";
	for( $i = 0;  $i <$num; $i++)
	{
		echo "
			<tr>
			<td>".$line[$i]['order_num']."</td>
			<td>".$line[$i]['date']."</td>
			<td>".$line[$i]['license_num']."</td>
			<td>".$line[$i]['gang_num']."</td>
			<td>".$line[$i]['id_acceptor']."</td>
			<td>".$line[$i]['VIN']."</td>
			<tr>
		";
		
	}
echo "</table>";
/*
    	foreach ($line as $col_value) {
        	echo "\t\t<td>$col_value</td>\n";
    	}

	echo "<td>управление</td>";
    	echo "</tr>";*/
	echo '<center>';
	navigate($pagename, $page, (int)$total);
	echo '</center>';
?>
</body>
</html>
