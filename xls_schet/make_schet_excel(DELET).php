<?php
require_once '../PHPExcel-1.8/Classes/PHPExcel.php';
require_once '../PHPExcel-1.8/Classes/PHPExcel/Writer/Excel2007.php';
require_once '../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php';
require_once '../connect_db.php';



$id=$_GET['id'];
$inn=$_GET['inn'];

// по id достаем номер КП
$stmt = $pdo->prepare("SELECT * FROM `reestrkp` WHERE id = :id");
$stmt ->execute(array('id' => $id));
$arr_id = $stmt->fetchAll(PDO::FETCH_ASSOC);

$KpNumber = $arr_id[0]['KpNumber'];
$KpDate = $arr_id[0]['KpData'];



$stmt = $pdo->prepare("SELECT * FROM `inncompany` WHERE inn = :inn");
$stmt ->execute(array('inn' => $inn));
$arr_inn = $stmt->fetchAll(PDO::FETCH_ASSOC);


$i=0;

$NameCompany = $arr_inn[0]['name'].", ИНН ".$arr_inn[0]['inn'].", ".$arr_inn[0]['adress'];
$nomer_schet = $KpNumber;

$month_list = array(

	1  => 'января',
	2  => 'февраля',
	3  => 'марта',
	4  => 'апреля',
	5  => 'мая', 
	6  => 'июня',
	7  => 'июля',
	8  => 'августа',
	9  => 'сентября',
	10 => 'октября',
	11 => 'ноября',
	12 => 'декабря'
);
$KpDate_d = date('d', strtotime($KpDate));
$KpDate_m = date('n', strtotime($KpDate));
$KpDate_Y = date('Y', strtotime($KpDate));
// $schet_date = $KpDate_d . ' ' . $month_list[date('n')] . ' ' . date('Y'); // 08 сентября 2022
$schet_date = $KpDate_d . ' ' . $month_list[$KpDate_m] . ' ' . $KpDate_Y; // 08 сентября 2022

// открываем файл с КП
// $xls = PHPExcel_IOFactory::load(__DIR__ . '/0000.xlsx');

$xls = PHPExcel_IOFactory::load("../".$_GET['LinkKp']);
$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$i=19;
$stop =0;
while ($stop <> 1 ) {
$name = $sheet->getCellByColumnAndRow(3, $i)->getValue();

if ($name == '') {
	$stop =1;
	break;
}

$ed_izm = $sheet->getCellByColumnAndRow(8, $i)->getValue();

$kolvo = $sheet->getCellByColumnAndRow(10, $i)->getValue();
$kolvo = str_replace(' ','',$kolvo);
$kolvo = str_replace(',','.',$kolvo);

$price = $sheet->getCellByColumnAndRow(11, $i)->getValue();
$price = str_replace(' ','',$price);
$price = str_replace(',','.',$price);

$prods[] = 
	array(
		'name'  => $name,
		'kol' => $kolvo,
		'ed_izm' => $ed_izm,
		'price' => $price
	);

$i++;
}
// цепляем доставку  
$i1= $i+8;
$price_dost = $sheet->getCellByColumnAndRow(12, $i1)->getValue();
$price_dost = str_replace(' ','',$price_dost);
$price_dost = str_replace(',','.',$price_dost);

$prods[] = 
	array(
		'name'  => 'Транспортные услуги',
		'kol' => '1',
		'ed_izm' => 'шт',
		'price' => $price_dost
	);



$xls = PHPExcel_IOFactory::load(__DIR__ . '/file.xlsx');

$xls->getProperties()->setTitle("Коммерческое предложение");
$xls->getProperties()->setCreator("Тендерный отдел");
$xls->getProperties()->setCompany("ООО ТД АНМАКС");

$xls->setActiveSheetIndex(0);
$sheet = $xls->getActiveSheet();
$sheet->setTitle('Счет');

// Заголовок накладной
$sheet->setCellValue("B13", "Оплата по заказу клиента №ТО-".$nomer_schet);
//Счет на оплату № ТО-772 от 4 мая 2022 г.
$sheet->setCellValue("B17", "Счет на оплату № ТО-".$nomer_schet." от ".$schet_date);

//Счет на оплату № ТО-772 от 4 мая 2022 г.
$sheet->setCellValue("F21", $NameCompany);

$line=25;


//  Жирная черта слева
$border_left = array(
	'borders'=>array(
		'left' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			'color' => array('rgb' => '000000')
		),
	)
);
$border_right = array(
	'borders'=>array(
		'right' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			'color' => array('rgb' => '000000')
		),
	)
);

foreach ($prods as $i => $prod) {
// Объединяем ячейки по горизонтали.
$sheet->mergeCells("B{$line}:C{$line}");
$sheet->mergeCells("D{$line}:AA{$line}");
$sheet->mergeCells("AB{$line}:AC{$line}");
$sheet->mergeCells("AD{$line}:AF{$line}");
$sheet->mergeCells("AG{$line}:AJ{$line}");
$sheet->mergeCells("AK{$line}:AR{$line}");

// заполняем значеия
	$sheet->setCellValue("B{$line}", ++$i);
	$sheet->getStyle("B{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$sheet->getStyle("B{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

		$sheet->setCellValue("D{$line}", $prod['name']);
	  // перенос слов в строке если выходит за ячейку
		$sheet->getStyle("D{$line}")->getAlignment()->setWrapText(true);
		//  подбираем ширину строки
	  $len=strlen ($prod['name']);

		$high =  ((int) ($len/70));
		if ($high >1) {
		$high = ($high - 1) * 11.25;
		$sheet->getRowDimension("{$line}")->setRowHeight($high);
		}

	$sheet->getStyle("D{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
	
	$sheet->setCellValue("AB{$line}", $prod['kol']);
	$sheet->getStyle("AB{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle("AB{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$sheet->setCellValue("AD{$line}", $prod['ed_izm']);
	$sheet->getStyle("AD{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle("AD{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$sheet->setCellValue("AG{$line}", number_format($prod['price'], 2, ',', ' '));
	// $sheet->setCellValue("AG{$line}", number_format($prod['price'], 2, ',', ' '));
	$sheet->getStyle("AG{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle("AG{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);

	$sheet->setCellValue("AK{$line}", number_format($prod['price'] * $prod['kol'], 2, ',', ' '));
	$sheet->getStyle("AK{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
	$sheet->getStyle("AK{$line}")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 
	$sheet->getStyle("B{$line}:B{$line}")->applyFromArray($border_left);
	$sheet->getStyle("AR{$line}:AR{$line}")->applyFromArray($border_right);

	// Подсчет "Итого".
	@$total += $prod['price'] * $prod['kol'];
	$line++;
}
// внутренние линии в таблице
$border = array(
	'borders'=>array(
		'inside' => array(
			'style' => PHPExcel_Style_Border::BORDER_THIN,
			'color' => array('rgb' => '000000')
		),
	)
);
$line2 = $line -1 ;
$sheet->getStyle("B25:AR{$line2}")->applyFromArray($border);

//  Жирная черта
$border_medium = array(
	'borders'=>array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			'color' => array('rgb' => '000000')
		),
	)
);
$sheet->getStyle("B{$line2}:AR{$line2}")->applyFromArray($border_medium);
// высота строки
$sheet->getRowDimension("{$line}")->setRowHeight(5);


// Итого
$line++;

$sheet->mergeCells("AG{$line}:AJ{$line}");
$sheet->setCellValue("AG{$line}", 'Итого:');
$sheet->getStyle("AG{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Размер шрифта 18
$sheet->getStyle("AG{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("AG{$line}")->getFont()->setBold(true);

$sheet->mergeCells("AK{$line}:AR{$line}");
$sheet->setCellValue("AK{$line}", number_format($total, 2, ',', ' '));
$sheet->getStyle("AK{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Размер шрифта 10
$sheet->getStyle("AK{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("AK{$line}")->getFont()->setBold(true);
// // НДС (20% от итого)
 $line++;
 $sheet->mergeCells("AE{$line}:AJ{$line}");
 $sheet->setCellValue("AE{$line}", 'В т.ч. НДС (20%):');
 $sheet->getStyle("AE{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Размер шрифта 18
$sheet->getStyle("AE{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("AE{$line}")->getFont()->setBold(true);

 $sheet->mergeCells("AK{$line}:AR{$line}");
 $sheet->setCellValue("AK{$line}", number_format(($total / 100) * 20, 2, ',', ' '));
 $sheet->getStyle("AK{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Размер шрифта 18
$sheet->getStyle("AK{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("AK{$line}")->getFont()->setBold(true);

 // Итого
$line++;

$sheet->mergeCells("AG{$line}:AJ{$line}");
$sheet->setCellValue("AG{$line}", 'Итого с НДС:');
$sheet->getStyle("AG{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Размер шрифта 18
$sheet->getStyle("AG{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("AG{$line}")->getFont()->setBold(true);


$sheet->mergeCells("AK{$line}:AR{$line}");
$sheet->setCellValue("AK{$line}", number_format($total, 2, ',', ' '));
$sheet->getStyle("AK{$line}")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// Размер шрифта 10
$sheet->getStyle("AK{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("AK{$line}")->getFont()->setBold(true);


// // Всего наименований
$line++;
$sheet->getRowDimension("{$line}")->setRowHeight(13);
$sheet->mergeCells("B{$line}:AR{$line}");
$sheet->setCellValue(
	"B{$line}",
	'Всего наименований ' . count($prods) . ', на сумму ' . number_format($total, 2, ',', ' ') . ' руб.'
);
// Размер шрифта 10
$sheet->getStyle("B{$line}")->getFont()->setSize(10);
// Здесь используется функция num2str() для получение суммы прописью, взято с https://habrahabr.ru/post/53210/.

// Еще нужно у суммы прописью сделать первую букву заглавной. Т.к. скрипт в UTF-8 функция ucfirst не работает, поэтому используется аналог – mb_ucfirst().
// СУММА прописью

$line++;
$sheet->mergeCells("B{$line}:AR{$line}");
$sheet->setCellValue("B{$line}", mb_strtoupper_first(num2str($total)));
$sheet->getStyle("A{$line}")->getFont()->setBold(true);
$sheet->getRowDimension("{$line}")->setRowHeight(13);
// Размер шрифта 10
$sheet->getStyle("B{$line}")->getFont()->setSize(10);
// Жирный
$sheet->getStyle("B{$line}")->getFont()->setBold(true);


// ***** Добавляем строку
$line++;
$sheet->getRowDimension("{$line}")->setRowHeight(7);
//  Жирная черта
$border_medium = array(
	'borders'=>array(
		'bottom' => array(
			'style' => PHPExcel_Style_Border::BORDER_MEDIUM,
			'color' => array('rgb' => '000000')
		),
	)
);
 
$sheet->getStyle("B{$line}:AR{$line}")->applyFromArray($border_medium);



// вставка изображения
$line2= $line +1;
	$objDrawing = new PHPExcel_Worksheet_Drawing();
	$objDrawing->setResizeProportional(false);  
	$objDrawing->setName('Подписи');
	$objDrawing->setDescription('Описание картинки');
	$objDrawing->setPath(__DIR__ . '/image.jpg');
	$objDrawing->setCoordinates("B{$line2}");                      
	$objDrawing->setOffsetX(10); 
	$objDrawing->setOffsetY(5);                
	// $objDrawing->setWidth(163); 
	// $objDrawing->setHeight(50); 
	$objDrawing->setWorksheet($sheet);

$objWriter = new PHPExcel_Writer_Excel2007($xls);
$file_name_schet = "../SCHET/"."Счет на оплату № ТО-".$nomer_schet." от ".$schet_date."(".$arr_inn[0]['name'].").xlsx";

$objWriter->save($file_name_schet);

// XLS
// Отдача на скачивание:

// $file = 'z_file.xlsx';
// $loca ="../".$_GET['LinkKp']; 
// $loca= "../SCHET/"."Счет на оплату № ТО-".$nomer_schet." от ".$schet_date."(".$arr_inn[0]['name'].").xlsx";
header("Location: ".$file_name_schet);

// $loca ="../index.php?id=".$id; 
// header("Location: ".$loca);

	
// $objWriter = new PHPExcel_Writer_Excel5($xls);
// $objWriter->save('php://output'); 
exit();


/**
 * Возвращает сумму прописью
 * @author runcore
 * @uses morph(...)
 */
function num2str($num) {
	$nul='ноль';
	$ten=array(
		array('','один','два','три','четыре','пять','шесть','семь', 'восемь','девять'),
		array('','одна','две','три','четыре','пять','шесть','семь', 'восемь','девять'),
	);
	$a20=array('десять','одиннадцать','двенадцать','тринадцать','четырнадцать' ,'пятнадцать','шестнадцать','семнадцать','восемнадцать','девятнадцать');
	$tens=array(2=>'двадцать','тридцать','сорок','пятьдесят','шестьдесят','семьдесят' ,'восемьдесят','девяносто');
	$hundred=array('','сто','двести','триста','четыреста','пятьсот','шестьсот', 'семьсот','восемьсот','девятьсот');
	$unit=array( // Units
		array('копейка' ,'копейки' ,'копеек',	 1),
		array('рубль'   ,'рубля'   ,'рублей'    ,0),
		array('тысяча'  ,'тысячи'  ,'тысяч'     ,1),
		array('миллион' ,'миллиона','миллионов' ,0),
		array('миллиард','милиарда','миллиардов',0),
	);
	//
	list($rub,$kop) = explode('.',sprintf("%015.2f", floatval($num)));
	$out = array();
	if (intval($rub)>0) {
		foreach(str_split($rub,3) as $uk=>$v) { // by 3 symbols
			if (!intval($v)) continue;
			$uk = sizeof($unit)-$uk-1; // unit key
			$gender = $unit[$uk][3];
			list($i1,$i2,$i3) = array_map('intval',str_split($v,1));
			// mega-logic
			$out[] = $hundred[$i1]; # 1xx-9xx
			if ($i2>1) $out[]= $tens[$i2].' '.$ten[$gender][$i3]; # 20-99
			else $out[]= $i2>0 ? $a20[$i3] : $ten[$gender][$i3]; # 10-19 | 1-9
			// units without rub & kop
			if ($uk>1) $out[]= morph($v,$unit[$uk][0],$unit[$uk][1],$unit[$uk][2]);
		} //foreach
	}
	else $out[] = $nul;
	$out[] = morph(intval($rub), $unit[1][0],$unit[1][1],$unit[1][2]); // rub
	$out[] = $kop.' '.morph($kop,$unit[0][0],$unit[0][1],$unit[0][2]); // kop
	return trim(preg_replace('/ {2,}/', ' ', join(' ',$out)));
}

/**
 * Склоняем словоформу
 * @ author runcore
 */
function morph($n, $f1, $f2, $f5) {
	$n = abs(intval($n)) % 100;
	if ($n>10 && $n<20) return $f5;
	$n = $n % 10;
	if ($n>1 && $n<5) return $f2;
	if ($n==1) return $f1;
	return $f5;
}

function mb_strtoupper_first($str, $encoding = 'UTF8')
{
    return
        mb_strtoupper(mb_substr($str, 0, 1, $encoding), $encoding) .
        mb_substr($str, 1, mb_strlen($str, $encoding), $encoding);
}