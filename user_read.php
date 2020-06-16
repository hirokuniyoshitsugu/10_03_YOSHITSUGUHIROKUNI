<?php
// 送信確認
// var_dump($_POST);
// exit();

session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
// check_session_id();

//項目入力のチェック
//値が存在しないor空で送信されてきた場合はNGにする
if (
    // !isset($_POST['number']) || $_POST['number'] == ''
    !isset($_POST['b']) || $_POST['b'] == '' ||
    !isset($_POST['w']) || $_POST['w'] == '' ||
    !isset($_POST['t']) || $_POST['t'] == ''

) {
    // 項目が入力されていない場合はここでエラーを出力し，以降の処理を中止する
    echo json_encode(["error_msg" => "no input"]);
    exit();
}

// 受け取ったデータを変数に入れる
$base = $_POST['b'];
$warimono = $_POST['w'];
$taste = $_POST['t'];
// $num = $_POST['number'];

// DB接続の設定
// DB名は`gsacf_x00_00`にする
$dbn = 'mysql:dbname=gsacf_l03_13;charset=utf8;port=3306;host=localhost';
$user = 'root';
$pwd = '';

try {
    // ここでDB接続処理を実行する
    $pdo = new PDO($dbn, $user, $pwd);
} catch (PDOException $e) {
    // DB接続に失敗した場合はここでエラーを出力し，以降の処理を中止する
    // echo json_encode(["db error" => "{$e->getMessage()}"]);
    // exit();
    exit('dbError:' . $e->getMessage());
}

// データ取得SQL作成
$sql = 'SELECT * FROM kakutel_table WHERE base=:base AND warimono=:warimono AND taste = :taste';

// $sql = 'SELECT * FROM kakutel_table  WHERE id =:id';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
// $stmt->bindValue(':id', $num, PDO::PARAM_INT);
$stmt->bindValue(':base', $base, PDO::PARAM_STR);
$stmt->bindValue(':warimono', $warimono, PDO::PARAM_STR);
$stmt->bindValue(':taste', $taste, PDO::PARAM_STR);
$status = $stmt->execute();

//データ確認
// var_dump($base);
// var_dump($warimono);
// var_dump($taste);
// exit();


// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    exit('sqlError:' . $error[2]);
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // <tr><td>name</td><td>warimono</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {

        $output .= "<tr>";
        $output .= "<td>{$record["name"]}</td>";
        $output .= "<td>{$record["base"]}</td>";
        $output .= "<td>{$record["warimono"]}</td>";
        $output .= "<td>{$record["taste"]}</td>";
        $output .= "</tr>";
    }
}

?>

<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DB連携型検索履歴</title>
    <style>
        th,
        td {
            border: solid 1px;
            /* 枠線指定 */
            padding: 10px;
            /* 余白指定 */
        }

        table {
            border-collapse: collapse;
            /* セルの線を重ねる */
        }
    </style>
</head>

<body>
    <!-- <form action='host_cakutelorder.php' method="POST"> -->
    <fieldset>
        <legend>検索履歴</legend>
        <a href="user_serch.php">入力画面</a>
        <table>
            <thead>
                <tr>
                    <th>名前</th>
                    <th>ベース</th>
                    <th>割りもの</th>
                    <th>味</th>
                </tr>
            </thead>
            <tbody>
                <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
                <?= $output ?>
            </tbody>
            <p>注文しますか?</p>
            <button>注文</button>
        </table>
    </fieldset>
    <!-- </form> -->
</body>

</html>