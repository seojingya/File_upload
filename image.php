<?php
/****
 * 1.建立資料庫及資料表
 * 2.建立上傳圖案機制
 * 3.取得圖檔資源
 * 4.進行圖形處理
 *   ->圖形縮放
 *   ->圖形加邊框
 *   ->圖形驗證碼
 * 5.輸出檔案
 */
if(!empty($_FILES['img']['tmp_name'])){
    $file="re_".$_FILES['img']['name'];
    move_uploaded_file($_FILES['img']['tmp_name'],"./img/".$file);
    echo "<img src='./img/$file'>";
    
    $percent=0.5;
    $border=10;

    list($width,$height)=getimagesize("./img/".$file);
    list($new_width,$new_height)=[$width*$percent,$height*$percent];

    $src_image=imagecreatefromjpeg("./img/".$file);
    $dst_image=imagecreatetruecolor($new_width,$new_height);
    // 換邊框顏色
    $blue=imagecolorallocate($dst_image,78,103,253);
    imagefill($dst_image,0,0,$blue);

    // 圖片上傳後往內移，加外框。將底框放下面，即可做出效果
    imagecopyresampled($dst_image,$src_image,10,10,0,0,$new_width-($border*2),$new_height-($border*2),$width,$height);
    
    imagejpeg($dst_image,"./img/small_".$file);
    echo "<img src='./img/small_{$file}'>";
}



?>
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
<h1 class="header">圖形處理練習</h1>
<!---建立檔案上傳機制--->
<form action="?" method="post" enctype="multipart/form-data">
    <div>
        上傳檔案: <input type="file" name="img" id="img">
    </div>
    <div>
        <input type="submit" value="上傳">
    </div>
</form>



<!----縮放圖形----->


<!----圖形加邊框----->


<!----產生圖形驗證碼----->



</body>
</html>