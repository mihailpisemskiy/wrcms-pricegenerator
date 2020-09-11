<?php
include 'pclzip.lib.php';
///ИСПОЛЬЗУЯ БИБЛИОТЕКУ ДОБАВЛЯЕМ В АРХИВ ФАЙЛ
function add_to_archive_new($name,$name_arh)
{
if (file_exists($name_arh.".zip")) {unlink($name_arh.".zip");} //удаляем старый файл архива
$arc = new PclZip($name_arh.".zip"); //создаем новый архив
$arc->add($name); //добавляем файл в архив
}

////ЦВЕТ ПО ДИАПАЗОНУ
function color_range($objPHPExcel,$color,$nachalo,$konec){
$sharedStyle1 = new PHPExcel_Style();
$sharedStyle1->applyFromArray(
	array('fill' 	=> array(
								'type'		=> PHPExcel_Style_Fill::FILL_SOLID,
								'color'		=> array('argb' => $color ) //'FFCCFFCC' 
							)
		 ));
$objPHPExcel->getActiveSheet()->setSharedStyle($sharedStyle1, $nachalo.':'.$konec);
}
/////ТРАНСЛИТ РУССКОГО ТЕКСТА
function translit($text){
// Делаем проверку на существование переменной
$st = $text;
$st2 = $st; // <----- делаем копию переменной до перевода
// Сначала заменяем "односимвольные" фонемы слова.
$st=strtr($st,"абвгдеёзийклмнопрстуфхъыэ_","abvgdeeziyklmnoprstufh'iei"); // <----- строчные
$st=strtr($st,"АБВГДЕЁЗИЙКЛМНОПРСТУФХЪЫЭ_","ABVGDEEZIYKLMNOPRSTUFH'IEI"); // <----- ПРОПИСНЫЕ
$st=strtr($st, array( "ж"=>"zh", "ц"=>"ts", "ч"=>"ch", "ш"=>"sh", "щ"=>"shch","ь"=>"", "ю"=>"yu", "я"=>"ya", "Ж"=>"ZH", "Ц"=>"TS", "Ч"=>"CH", "Ш"=>"SH", "Щ"=>"SHCH","Ь"=>"", "Ю"=>"YU", "Я"=>"YA", "ї"=>"i", "Ї"=>"Yi", "є"=>"ie", "Є"=>"Ye" ));
return $st;
}

/////БЭКАП СТАРЫХ ПРАЙСОВ
/////////ПРОВЕРКА СУЩ.ДИРЕКТОРИЙ, СОЗДАНИЕ. КОПИРОВАНИЕ XLS,ZIP
function backup_price($cityname,$path_xls,$path_zip)
{
	$structure = 'prices/backup/'.$cityname.'/'.date('d.m.y').'/'.date('H-i');
	
	if (file_exists($path_xls))
	{
		if (!file_exists($structure))
		{
			if (!mkdir($structure, 0777, true)) 
			{
				die('<p>Не удалось создать директории...</p>');
			}
		
		}
		if (copy($path_xls, $structure.'/'.$cityname.'.xls'))
		{ 
			echo "<p>Копирование успешно выполнено XLS</p>"; 
		}
		else
		{ 
			echo "<p>Ошибка при копировании XLS</p>"; 
		}
	}

		if (file_exists($path_zip))
	{
		if (!file_exists($structure))
		{
			if (!mkdir($structure, 0, true)) 
			{
				die('<p>Не удалось создать директории...</p>');
			}
		}
		
		if (copy($path_zip, $structure.'/'.$cityname.'.zip'))
		{ 
			echo "<p>Копирование успешно выполнено ZIP</p>"; 
		}
		else
		{ 
			echo "<p>Ошибка при копировании ZIP</p>"; 
		}
	}
}

///ДОБАВЛЕНИЕ ФАЙЛА В АРХИВ
function file_add_archive($name,$name_arh,$NamePrice){
$filepath = $name_arh.'.zip';
$zip = new ZipArchive;
// Создаем архив
if ($zip->open($filepath, ZipArchive::CREATE) === TRUE){
   // первый параметр - откуда взять, второй как назвать внутри архива
   $zip->addFile($name, $NamePrice);
   // закрыть архив
   $zip->close();
}else echo 'Ошибка открытия файла архива!';
}
////ДЕКОДИРУЕМ 1251 кодировку
function translate_ch($text){
if (mb_check_encoding($text, 'Windows-1251') && !mb_check_encoding($text, 'UTF-8'))
        $text = mb_convert_encoding($text, 'UTF-8', 'Windows-1251');
		return $text;
}

//////////////ДЕЛАЕМ ГРАНИЦУ
function granica($r1,$r2,$objPHPExcel) {
$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle($r1.':'.$r2)->applyFromArray($styleArray);
unset($styleArray);
}
/////////////////////////////////////
//ПОДГОТОВКА ЛИСТА ДЛЯ ШАПКИ
function podgotovka_lista($r,$objPHPExcel){
//ШИРИНА СТОЛБЦОВ
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth(6);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setWidth(6);
//$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(6);
//$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setWidth(6);
////////////////////
$objPHPExcel->getActiveSheet()->mergeCells('A'.$r.':D'.$r);
$objPHPExcel->getActiveSheet()->mergeCells('E'.$r.':R'.$r);
$r++; $objPHPExcel->getActiveSheet()->mergeCells('A'.$r.':B'.$r);
$objPHPExcel->getActiveSheet()->mergeCells('C'.$r.':Q'.$r);
$r++;
$objPHPExcel->getActiveSheet()->mergeCells('A'.$r.':B'.($r+1));
$objPHPExcel->getActiveSheet()->mergeCells('D'.$r.':Q'.$r);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->getActiveSheet()->mergeCells('A'.$r.':B'.($r+1));
//$objPHPExcel->getActiveSheet()->mergeCells('C'.$r.':C'.($r+1));
$objPHPExcel->getActiveSheet()->mergeCells('R'.$r.':R'.($r+1));
}
/// ИНФОРМАЦИЯ ФИЛИАЛА///
function filial_info_shapka($objPHPExcel,$gorod,$iz,$r,$type){
podgotovka_lista($r,$objPHPExcel);
//Создадим заголовок таблицы тарифов
//Информация филиала
$query = 'SELECT * FROM filial_info WHERE filial="'.$gorod.'"';	
//if (mb_check_encoding($query, 'Windows-1251') && !mb_check_encoding($query, 'UTF-8'))
        //$query = mb_convert_encoding($query, 'UTF-8', 'Windows-1251');
$results = mysql_query($query);
while ($line = mysql_fetch_assoc($results)) {
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$r, translate_ch($line['filial_name']));
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$r)->getFont()->setBold(true)->setSize(13);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('E'.$r, translate_ch($line['tel_number']));
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$r)->getFont()->setSize(10);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('E'.$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
$r++;
if ($iz==true){
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$r, translate_ch('Действует с '.$line['actual_date_iz']));}
else
{
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$r, translate_ch('Действует с '.$line['actual_date_v']));}
$objPHPExcel->setActiveSheetIndex(0)->getStyle('A'.$r)->getFont()->setSize(10);
////////////////////// ЦВЕТ
$objPHPExcel->getActiveSheet()->getStyle('A'.$r)->getFont()->getColor()->applyFromArray(array("rgb" => 'FF0000'));
///////////////////////
//$objPHPExcel->getActiveSheet()->getStyle('A'.$r)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_DATE_XLSX15);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$r)->getFont()->setBold(true)->setSize(14);
$objPHPExcel->setActiveSheetIndex(0)->getStyle('C'.$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
	//ИЗ ГОРОДА
if ($iz==true){
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$r, translate_ch('Прайс-лист на перевозку сборных грузов из г. '.$gorod.''));
}
else//В ГОРОД
{
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$r, translate_ch('Прайс-лист на перевозку сборных грузов в г. '.$gorod.''));
}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$r, translate_ch($line['email']));
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setWidth(25);
}
if ($iz==true){
	$r++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$r, translate_ch('В город'));
	color_range($objPHPExcel,'00FFFF00','A'.$r,'R'.($r+1)); // ЦВЕТ ШАПКИ @ ИЗ ГОРОДА @
	}
else
	{
	$r++;
	$objPHPExcel->setActiveSheetIndex(0)->setCellValue('A'.$r, translate_ch('Из города'));
	color_range($objPHPExcel,'FF00FFFF','A'.$r,'R'.($r+1)); // ЦВЕТ ШАПКИ @ В ГОРОД @
	}
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$r, translate_ch('Мин.'));
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.($r+1), translate_ch('стоим.'));
if ($type=='ves'){
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$r, translate_ch('Тарифы по весу (руб/кг)'));
};
if ($type=='ob'){
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('D'.$r, translate_ch('Тарифы по объему (руб/м3)'));
};
$objPHPExcel->setActiveSheetIndex(0)->getStyle('D'.$r)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
$objPHPExcel->setActiveSheetIndex(0)->setCellValue('R'.$r, translate_ch('Контакты в городах'));
}

function check_exist_city($filial_name){ // ПРОВЕРКА НАЛИЧИЯ ГОРОДА В БАЗЕ
	$query_check_city = "SELECT COUNT(*) FROM filial_info WHERE filial='".$filial_name."'";
	$result = mysql_query($query_check_city);
	$result = mysql_fetch_row($result);
	if ($result[0]==1){
		return true;
	}else{
		return false;
	}
}

function set_actual_date($filial_name,$date,$iz){ // ИЗМЕНЕНИЕ ДАТЫ АКТУАЛЬНОСТИ ПРИ НАЛИЧИИ ГОРОДА В БАЗЕ
	if (check_exist_city($filial_name)){
		if ($iz==true){
			$query_change_date = "UPDATE filial_info SET actual_date_iz='".$date."' WHERE filial='".$filial_name."'"; //ИЗ ГОРОДА
		}else{
			$query_change_date = "UPDATE filial_info SET actual_date_v='".$date."' WHERE filial='".$filial_name."'"; //В ГОРОД
		}
	if (mysql_query($query_change_date)){
		return true;
	}else{
		return false;
	}}else{
		return false;
	}
}
?>