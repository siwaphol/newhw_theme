
<?php

error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
  die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once '../Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();
$result =DB::select('SELECT re.student_id,st.firstname_th,st.lastname_th,st.email FROM users st
          left join course_student re on st.id=re.student_id
          where  re.course_id=? and re.section=?
          and re.semester=? and re.year=?
          order by re.student_id asc',array($course['co'],$course['sec'],Session::get('semester'),Session::get('year')));

$count=count($result);

$row = 1;
$objPHPExcel->getActiveSheet()->setCellValue('A'.$row, 'No')
                              ->setCellValue('B'.$row, 'Student ID')
                              ->setCellValue('C'.$row, 'Name')
                              ->setCellValue('D'.$row, 'Email');


$row++;

for($i=0;$i<$count;$i++) {
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, $i+1)
                                  ->setCellValue('B'.$row, $result[$i]->student_id)
                                  ->setCellValue('C'.$row, $result[$i]->firstname_th." ".$result[$i]->lastname_th)
                                  ->setCellValue('D'.$row, $result[$i]->email);

   $row++;
}
$objPHPExcel->getActiveSheet()->setTitle('นักศึกษาวิชา'.$course['co'].' ตอน '.$course['sec']);
$name='รายชื่อนักศึกษากระบวนวิชา'.$course['co'].' ตอน '.$course['sec'].'.xlsx';
// Set active sheet index to the first sheet, so Excel opens this as the first sheet
                $objPHPExcel->setActiveSheetIndex(0);


                // Redirect output to a client’s web browser (Excel5)
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename='.$name);
                header('Cache-Control: max-age=0');
                // If you're serving to IE 9, then the following may be needed
                header('Cache-Control: max-age=1');

                // If you're serving to IE over SSL, then the following may be needed
                header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                header ('Pragma: public'); // HTTP/1.0

                //$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
                $objWriter->save('php://output');
?>