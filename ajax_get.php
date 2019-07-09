<?php
include('functions.php');

//DB接続
$pdo = connectToDb();

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




// if ($status == false) {
//   showSqlErrorMsg($stmt);
// } else {
//   $view = '';
//   while ($result = $stmt->fetch(PDO::FETCH_ASSOC)) {
//     $view .= '<li class="list-group-item">';
//     $view .= '<p>' . $result['deadline'] . '-' . $result['task'] . '</p>';
//     $view .= '<p>' . $result['comment'] . '</p>';
//     $view .= '<img src="'.$result['image'].'" alt="" height="150px">'; 

//     // imgタグで出力しよう！
//     $view .= '<div><a href="detail.php?id=' . $result['id'] . '" class="badge badge-primary">Edit</a>';
//     $view .= '<a href="delete.php?id=' . $result['id'] . '" class="badge badge-danger">Delete</a></div>';
//     $view .= '</li>';
//   }
// }
// ?>

