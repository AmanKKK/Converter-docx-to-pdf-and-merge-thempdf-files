<?php
use \setasign\Fpdi\Fpdi;
require_once 'vendor/setasign/fpdi/src/autoload.php';
require_once 'vendor/fpdf/fpdf.php';
//require_once 'vendor/setasign/fpdi/src/Fpdi.php';

/* */
if (isset($_POST['uploadBtn']) && $_POST['uploadBtn'] == 'Upload') { // проверка на валидность запроса POST;
   
}else{
   echo 'INVALID VALUE ';
}
if (isset($_FILES['uploadedFile']) && $_FILES['uploadedFile']['error'] === UPLOAD_ERR_OK) { // проверка на корректность загрузки файла;
      
}else{
   echo $_FILES['uploadedFile']['error'];
}

if(isset($_FILES['uploadedFile']) && isset($_FILES['uploadedFile1'])){
   echo 'Success'. '<br>';
   echo 'Первый файл:'. ' '. $_FILES['uploadedFile']['name']. '<br>';
   echo 'Второй файл:'. ' '. $_FILES['uploadedFile1']['name'];
}else{
   echo 'error';
}

/* Данные полученных файлов */
$fileTmpPath = $_FILES['uploadedFile']['tmp_name'];
$fileName = $_FILES['uploadedFile']['name'];
$fileSize = $_FILES['uploadedFile']['size'];
$fileType = $_FILES['uploadedFile']['type'];
$fileNameCmps = explode(".", $fileName);
$fileExtension = strtolower(end($fileNameCmps)); //возврат строки в нижнем регистре;
$uploadFileDir = 'uploaded_files/';
$dest_path = $uploadFileDir . $fileName;


$fileTmpPath1 = $_FILES['uploadedFile1']['tmp_name'];
$fileName1 = $_FILES['uploadedFile1']['name'];
$fileSize1 = $_FILES['uploadedFile1']['size'];
$fileType1 = $_FILES['uploadedFile1']['type'];
$fileNameCmps1 = explode(".", $fileName1);
$fileExtension1 = strtolower(end($fileNameCmps1));
$uploadFileDir1 = 'uploaded_files/';
$dest_path1 = $uploadFileDir1 . $fileName1;



$allowedfileExtensions = array('pdf','doc','docx');

echo '<br>'.'dest_path: '. $dest_path;
echo '<br>'.'dest_path1: '. $dest_path1;

$absolutePath='C:/OSPanel/domains/part2/'; //для команды soffice, получение файла для конвертации;
$uploading_path='C:/OSPanel/domains/part2/uploaded_files';// путь, где будет сконвертированный pdf файл;
$path_for_merging_pdf='C:OSPanel/domains/part2/uploaded_files/';
$path_for_pdf=$path_for_merging_pdf.$fileName;//путь к pdf файлу;
//$merged_file_name=$fileNameCmps[0].'.pdf'; //название "склеинового" файла pdf;

if (in_array($fileExtension, $allowedfileExtensions)) { // проверка на соотвествие расширений;
   move_uploaded_file($fileTmpPath, $dest_path);
 
   if($fileNameCmps[1]==='docx'){
      $PathToFile=$absolutePath.$dest_path;
      
      chdir('C:/OSPanel/LibreOffice/program');
      `soffice --headless --convert-to pdf $PathToFile --outdir $uploading_path `;
      $new_file_name=$fileNameCmps[0].'.pdf'; //название "склеиного" файла pdf;

   }else{echo '<br>' .'error0';}

}else{
  echo 'Invalid fileExtension'.'<br>';
  echo 'You can upload only files with : jpg, gif, png, zip, txt, xls, doc, docx extensions';
}

if (in_array($fileExtension1, $allowedfileExtensions)) { 
  chdir('C:/OSPanel/domains/part2');
  move_uploaded_file($fileTmpPath1, $dest_path1);
  
  if($fileNameCmps1[1]==='docx'){
   $PathToFile1=$absolutePath.$dest_path1;
   chdir('C:/OSPanel/LibreOffice/program');
   `soffice --headless --convert-to pdf $PathToFile1 --outdir $uploading_path`;

  
   
  }else{echo '<br>'. 'error1';}

}else{
  echo 'Invalid fileExtension'.'<br>';
  echo 'You can upload only files with : jpg, gif, png, zip, txt, xls, doc, docx extensions';
}
chdir('C:/OSPanel/domains/part2');

/*----------------------------------------------------------------------------------------------------- */

$path_to_first_pdf = $path_for_merging_pdf.$new_file_name;
$path_to_second_pdf=$path_for_merging_pdf.$fileName1;

$files=array(
   $path_to_first_pdf,
   $path_to_second_pdf,
);

$pdf=new Fpdi();

// iterate through the files
foreach ($files AS $file) {
   // get the page count
   $pageCount = $pdf->setSourceFile($file);
   // iterate through all pages
   for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
       // import a page
       $templateId = $pdf->importPage($pageNo);
       // get the size of the imported page
       $size = $pdf->getTemplateSize($templateId);

       // add a page with the same orientation and size
       $pdf->AddPage($size['orientation'], $size);

       // use the imported page
       $pdf->useTemplate($templateId);

       $pdf->SetFont('Helvetica');
       $pdf->SetXY(5, 5);
       $pdf->Write(8, 'A simple concatenation demo with FPDI');
   }
}

// Output the new PDF




$pdf->Output("F",'C:/OSPanel/domains/part2/uploaded_files/merged_file/new.pdf');






























/* не разобрался
$path_to_pdf_file=$path_for_merging_pdf.$newFileName; //путь к сконвертированному файлу pdf ;

$fileArray=array(
   $path_to_pdf_file,
   $path_for_pdf
);

$savedir='C:/OSPanel/domains/part2/uploaded_files/merged_file/';
$outputName=$savedir.$merged_file_name;

chdir('C:/OSPanel/gs/gs9.25/bin');
$cmd="gs -q -dNOPAUSE -dBATCH -sDEVICE=pdfwrite -sOutputFile=$outputName";
foreach($fileArray as $file){
   $cmd.=$file. "musk.pdf";
}
$result=shell_exec($cmd);
*/












 



