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

//DB接続
$pdo = connectToDb();

$sql = 'INSERT INTO php02_table(id, task, deadline, comment, indate) VALUES(NULL, :a1, :a2, :a3, sysdate())';

$stmt = $pdo->prepare($sql);
$stmt->bindValue(':a1', $task, PDO::PARAM_STR);    //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a2', $deadline, PDO::PARAM_STR);   //Integer（数値の場合 PDO::PARAM_INT)
$stmt->bindValue(':a3', $comment, PDO::PARAM_STR);  //Integer（数値の場合 PDO::PARAM_INT)
$status = $stmt->execute();

//データ表示SQL作成
$sql = 'SELECT * FROM php02_table ORDER BY deadline DESC';
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();


//データ表示
if($status == false){
  showSqlErrorMsg($stmt);
} else {
  $res =[];
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)){
  $res [] = $result;
  }

echo json_encode($res);
}

?>


<!-- if ($status == false) {
  showSqlErrorMsg($stmt);
} else {
  $view = '';
  while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $view .= '<li class="list-group-item">';
    $view .= '<p>' . $result['deadline'] . '-' . $result['task'] . '</p>';
    $view .= '<p>' . $result['comment'] . '</p>';
    $view .= '<img src="'.$result['image'].'" alt="" height="150px">'; 

    // imgタグで出力しよう！
    $view .= '<div><a href="detail.php?id=' . $result['id'] . '" class="badge badge-primary">Edit</a>';
    $view .= '<a href="delete.php?id=' . $result['id'] . '" class="badge badge-danger">Delete</a></div>';
    $view .= '</li>';
  }
}

?> -->

