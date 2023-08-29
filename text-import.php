<?php include_once "DB.php";?>
<style>


table{
    border:1px solid #ccc;
    box-shadow: 3px 3px 15px #aaa;
    padding:20px;
    border-collapse: collapse;
}    

td{
    border:1px solid #ccc;
    padding:5px 10px;
    text-align: center;
}
</style>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>文字檔案匯入</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<h1 class="header">文字檔案匯入練習</h1>
<!---建立檔案上傳機制--->
<form action="?" method="post" enctype="multipart/form-data">
<input type="file" name="text" id="text">
<input type="submit" value="上傳">

</form>


<!----讀出匯入完成的資料----->
<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳檔案機制
 * 3.取得檔案資源
 * 4.取得檔案內容
 * 5.建立SQL語法
 * 6.寫入資料庫
 * 7.結束檔案
 */


if(!empty($_FILES['text']['tmp_name'])){
    echo "檔名是:".$_FILES['text']['name'];
    echo "<br>";
    echo "檔案大小是:".$_FILES['text']['size'];
    echo "<hr>";

    move_uploaded_file($_FILES['text']['tmp_name'],"./document/{$_FILES['text']['name']}");
    $path="./document/{$_FILES['text']['name']}";
    // 使用 'r' 模式來讀取檔案
$file = fopen($path, "r");
echo "<table>";
if ($file) {
    //處理第一列抬頭列
    $line = fgets($file);
    if($line!==false){
        $cols=explode(",",$line);
    
        for($i=0;$i<count($cols);$i++){
            echo "<td>";
            echo $cols[$i]; 
            echo "</td>";
        }
        echo "<td>";
        echo "狀態";
        echo "</td>";
    }
    // 讀取檔案到最後
    $count=0;
    while (($line = fgets($file)) !== false) {
        echo "<tr>";
        $cols=explode(",",$line);
        $sql=$db->save([
            'area'=>$cols[1], 
            'city'=>$cols[2], 
            'name'=>$cols[3], 
            'address'=>$cols[4], 
            'telephone'=>$cols[5], 
            'url'=>$cols[6], 
        ]);

        for($i=0;$i<count($cols);$i++){
            echo "<td>";
            echo $cols[$i];
            echo "</td>";
        }
        if($sql>0){
            echo "<td>成功</td>";
        }else{
            echo "<td>失敗</td>";
        }
        echo "</tr>";

        $count++;
    }
    fclose($file);
} else {
    // 檔案開啟失敗
    echo "檔案開啟失敗";
}

echo "</table>";
echo "合計匯入資料表筆數:$count 筆";
}

?>


</body>
</html>