<p><a href="../utils/t.php"><h2>Загрузка прайс-листов в БД</h2></a></p>
<?php
require_once("../_common/setup.php");
include 'a.charset.php';
include 'my_function.php';
$city = '';
$city = $_GET['otkuda'];
$kol=1; // количество городов для построения прайсов
//echo charset_x_win($city);
$query = 'SELECT DepartureName FROM prices GROUP BY DepartureName ORDER BY DepartureName ASC';
$results = mysql_query($query);
echo"  <p><b>Укажите город для которого создать прайс:</b></p>";
echo "<form name='form1' method='post' action='copy_xls.php'>";
echo "<select name='town' onchange='document.location=this.options[this.selectedIndex].value'>";
if ($city<>''){
 echo "<option  value='create_price.php?otkuda=".$city."'>".$city."</option>\n";
}
else
{
echo "<option>Выберите город</option>";}
while ($line = mysql_fetch_assoc($results)) {
 echo "<option value='create_price.php?otkuda=".$line["DepartureName"]."'>".$line["DepartureName"]."</option>\n";
 }
 echo "</select>";

$query = 'SELECT ArrivalName FROM prices GROUP BY ArrivalName ORDER BY ArrivalName ASC';
$results = mysql_query($query);
?>
<p><input type="checkbox" name="priceizcreate" value="priceizcreate">Не делать прайс из города.</p>

<?php 

?>

<p>Дата актуальности: <input type="text" name="actualdate" value="
<?php $price_date_change = time() + (1 * 24 * 60 * 60); // завтрашний день 
echo date('d.m.y',$price_date_change); //преобразуем в формат дд.мм.гг ?>">
</p>

<input type="submit" value='Создать прайсы'><br>
<table><tr>
<?php
while ($line = mysql_fetch_assoc($results)) {
	echo '<td><input type="checkbox" name="gorod'.$kol.'" value="'.$line['ArrivalName'].'">'.$line['ArrivalName'].'</td>';
	if (($kol%6)==0){
		echo "<tr>";
		echo "</tr>";
	}
	$kol++;
}
?>
</table>
<?
if ($city<>''){
echo '<br>Всего городов: '.$kol;
?>
<p><input type="text" name='town' value='<?php echo $city; ?>' hidden></p>
<?php } ?>
<p><input type="text" name='kol' value='<?php echo $kol; ?>' hidden></p>
 </form>