<?php
//Fileアップロードチェック
// var_dump($_FILES);
// exit();
// var_dump($extension);

    // ③サーバの保存領域に移動&④表示
    // $img=;
    if(isset($_FILES['upfile']) && $_FILES['upfile']['error'] ==0){
// ファイルをアップロードしたときの処理
    // ①送信ファイルの情報取得
    $uploadedFileName = $_FILES['upfile']['name'];
    $tempPathName = $_FILES['upfile']['tmp_name'];
    $fileDirectoryPath = 'upload/';

    $extension = pathinfo($uploadedFileName, PATHINFO_EXTENSION); 
    $uniqueName = date('YmdHis').md5(session_id()) . "." . $extension; 
    $fileNameToSave = $fileDirectoryPath.$uniqueName;

        if(is_uploaded_file($tempPathName)){
            if(move_uploaded_file($tempPathName, $fileNameToSave)){
            chmod($fileNameToSave, 0644);
            $img = '<img src="'. $fileNameToSave . '" >'; 
            }else{
    $img = '保存に失敗しました';
            }
        }else{
    $img = '画像があがっていないです';
        }
    }else{
    $img = '画像が送信されていません';

    }



//     if(is_uploaded_file($tempPathName)){
//         if (move_uploaded_file($tempPathName, $fileNameToSave)) {  
//             chmod($fileNameToSave, 0644);
//             $img = '<img src="'. $fileNameToSave . '" >'; 
//         } else {
//             // ファイルをアップしていないときの処理
//             $img = '保存に失敗しました';
//         }
//     } else {
//         // ファイルをアップしていないときの処理
//         $img = '画像があがっていないです';
// } else {
//     // ファイルをアップしていないときの処理
//     $img = '画像が送信されていません';
// }
// }


?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>FileUploadテスト</title>
</head>

<body>

    <!-- ここに画像出力！ -->
    <?=$img?>
</body>

</html>