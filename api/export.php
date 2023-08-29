<?php 
require '../vendor/autoload.php';
include_once "../DB.php";
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set("isPhpEnabled", true);
$dompdf = new Dompdf();


$sql="select * from `factory` where id in(".join(",",$_POST['data']).")";
$data=$db->q($sql);
$file=fopen("../export.csv",'w+');
fwrite($file, "\xEF\xBB\xBF");
$html="<div style=font-family:'微軟正黑體'>序號,地區別,縣市,觀光工廠名稱,地址,觀光工廠預約電話,網址\n";
fwrite($file,$html);
foreach($data as $row){
   $str=join(",",$row);
   $html.=$str;
   fwrite($file,$str);
}


$dompdf->loadHtml($html."</div>");
$dompdf->render();
$output = $dompdf->output();
file_put_contents('../export.pdf', $output);
fclose($file);
?>

<a href="export.csv" download>請下載(.csv)</a>
<a href="export.pdf" download>請下載(.pdf)</a>