<?php
include("functions.php");

// 送信確認
// var_dump($_POST);
// exit();

// 項目入力のチェック
// 値が存在しないor空で送信されてきた場合はNGにする
if (
    !isset($_POST['n']) || $_POST['n'] == '' ||
    !isset($_POST['b']) || $_POST['b'] == '' ||
    !isset($_POST['w']) || $_POST['w'] == '' ||
    !isset($_POST['t']) || $_POST['t'] == ''

) {
    // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

// 受け取ったデータを変数に入れる
$name = $_POST['n'];
$base = $_POST['b'];
$warimono = $_POST['w'];
$taste = $_POST['t'];

// DB接続
$pdo = connect_to_db();

// データ登録SQL作成
// `created_at`と`updated_at`には実行時の`sysdate()`関数を用いて実行時の日時を入力する
$sql = 'INSERT INTO kakutel_table(id, name, base, warimono, taste) VALUES(NULL, :name, :base, :warimono, :taste)';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':name', $name, PDO::PARAM_STR);
$stmt->bindValue(':base', $base, PDO::PARAM_STR);
$stmt->bindValue(':warimono', $warimono, PDO::PARAM_STR);
$stmt->bindValue(':taste', $taste, PDO::PARAM_STR);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    $alert = "<script type='text/javascript'>alert('登録完了しました。');</script>";
    echo $alert;
    header("Location:host_input.php");
    exit();
}
