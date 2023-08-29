<?php include_once "DB.php";?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>觀光工廠</title>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
</head>
<body>
<h1>觀光工廠名單</h1>    
<button class="export">匯出</button>
<div class='download'></div>
<table>
<tr>
    <td><input type="checkbox" class='select-all'>全選</td>
    <td>序號</td>
    <td>地區</td>
    <td>縣市</td>
    <td>名稱</td>
    <td>電話</td>
    <td>地址</td>
    <td>網址</td>
</tr>
<?php
$factorys=$db->all();
foreach($factorys as $factory){
    echo "<tr>";
    echo "<td>";
    echo "<input type='checkbox' class='chk' name='factory[]' value='{$factory['id']}'>";
    echo "</td>";
    foreach($factory as $col){
        echo "<td>";
        echo $col;
        echo "</td>";
    }
    echo "</tr>";
}
?>

</table>
</body>
</html>
<script>
$(".select-all").on("change",function(){
    type=$(this).prop('checked')
    $(".chk").prop('checked',type)
})


$(".export").on("click",function(){
    if($(".chk").is(":checked")){
        let data=new Array();
        $(".chk").each((idx,el)=>{
            if($(el).is(":checked")){
                data.push($(el).val());
            }
        })

        console.log(data)
        $.post("./api/export.php",{data},(download)=>{
            $('.download').html(download)
        })
    }else{
        alert("還沒有選取任何項目，不需匯出")
    }
})
</script>
