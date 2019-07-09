<?php
include('functions.php');

// 入力チェック
if (
  !isset($_POST['task']) || $_POST['task'] == '' ||
  !isset($_POST['deadline']) || $_POST['deadline'] == ''
) {
  exit('ParamError');
}

//POSTデータ取得
$task = $_POST['task'];
$deadline = $_POST['deadline'];
$comment = $_POST['comment'];
// $image = $_POST['image'];


// Fileアップロードチェック
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
                exit("保存に失敗しました");
              }
             }
              else {
                exit("画像があがっていないです");
              } 
            }else {
                exit("画像が送信されていません");
              }
    // $img = '保存に失敗しました';
    //         }
    //     }else{
    // $img = '画像があがっていないです';
    //     }
    // }else{
    // $img = '画像が送信されていません';
    // }



// DB接続
$pdo = connectToDb();

// データ登録SQL作成
// imageカラムとバインド変数を追加
$sql = 'INSERT INTO php02_table(id, task, deadline, comment, image, indate)
VALUES(NULL, :a1, :a2, :a3, :image, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $task, PDO::PARAM_STR);
$stmt->bindValue(':a2', $deadline, PDO::PARAM_STR);
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);
$stmt->bindValue(':image', $fileNameToSave, PDO::PARAM_STR);

// :imageを$file_nameで追加！
$status = $stmt->execute();

//データ登録処理後
if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  //index.phpへリダイレクト
  header('Location: index.php');
}
