<?php

session_start(); // セッションの開始
include('functions.php'); // 関数ファイル読み込み
// check_session_id();

// DB接続
$pdo = connect_to_db();

// データ取得SQL作成
$sql = 'SELECT * FROM kakutel_table';

// SQL準備&実行
$stmt = $pdo->prepare($sql);
$status = $stmt->execute();

// データ登録処理後
if ($status == false) {
    // SQL実行に失敗した場合はここでエラーを出力し，以降の処理を中止する
    $error = $stmt->errorInfo();
    echo json_encode(["error_msg" => "{$error[2]}"]);
    exit();
} else {
    // 正常にSQLが実行された場合は入力ページファイルに移動し，入力ページの処理を実行する
    // fetchAll()関数でSQLで取得したレコードを配列で取得できる
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  // データの出力用変数（初期値は空文字）を設定
    $output = "";
    // <tr><td>deadline</td><td>todo</td><tr>の形になるようにforeachで順番に$outputへデータを追加
    // `.=`は後ろに文字列を追加する，の意味
    foreach ($result as $record) {
        $output .= "<tr>";
        $output .= "<td>{$record["name"]}</td>";
        $output .= "<td>{$record["base"]}</td>";
        $output .= "<td>{$record["warimono"]}</td>";
        $output .= "<td>{$record["taste"]}</td>";
        $output .= "</tr>";
    }
    // $valueの参照を解除する．解除しないと，再度foreachした場合に最初からループしない
    // 今回は以降foreachしないので影響なし
    unset($value);
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cakutel 検索サービス</title>
    <style>
        /*タブ切り替え全体のスタイル*/
        .tabs {
            margin-top: 50px;
            padding-bottom: 40px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            width: 700px;
            margin: 0 auto;
        }

        /*タブのスタイル*/
        .tab_item {
            width: calc(100%/3);
            height: 50px;
            border-bottom: 3px solid #5ab4bd;
            background-color: #d9d9d9;
            line-height: 50px;
            font-size: 16px;
            text-align: center;
            color: #565656;
            display: block;
            float: left;
            text-align: center;
            font-weight: bold;
            transition: all 0.2s ease;
        }

        .tab_item:hover {
            opacity: 0.75;
        }

        /*ラジオボタンを全て消す*/
        input[name="tab_item"] {
            display: none;
        }

        /*タブ切り替えの中身のスタイル*/
        .tab_content {
            display: none;
            padding: 40px 40px 0;
            clear: both;
            overflow: hidden;
        }


        /*選択されているタブのコンテンツのみを表示*/
        #all:checked~#all_content,
        #programming:checked~#programming_content,
        #design:checked~#design_content {
            display: block;
        }

        /*選択されているタブのスタイルを変える*/
        .tabs input:checked+.tab_item {
            background-color: #5ab4bd;
            color: #fff;
        }
    </style>
</head>

<body>
    <h1>カクテル 検索/注文サービス</h1>
    <div class="tabs">
        <input id="all" type="radio" name="tab_item" checked>
        <label class="tab_item" for="all">カクテル検索</label>
        <input id="programming" type="radio" name="tab_item">
        <label class="tab_item" for="programming">全メニュー</label>
        <input id="design" type="radio" name="tab_item">
        <label class="tab_item" for=order>注文</label>
        <div class="tab_content" id="all_content">
            <!-- 総合の内容がここに入ります -->
            <form action="user_read.php" method="POST">
                <fieldset>
                    <legend>入力画面</legend>
                    <a href="user_read.php">検索結果画面</a>
                    <!-- <div>
                ID: <input type="number" name="number">
            </div> -->
                    <div>
                        ベース: <input type="text" name="b" list="base">
                        <datalist id="base">
                            <option value="ジン">ジン</option>
                            <option value="ウォッカ">ウォッカ</option>
                            <option value="テキーラ">テキーラ</option>
                            <option value="ラム">ラム</option>
                            <option value="ビール">ビール</option>
                            <option value="ワイン">ワイン</option>
                            <option value="ウイスキー">ウイスキー</option>
                            <option value="ラム">ラム</option>
                            <option value="ニホンシュ">日本酒</option>
                            <option value="ショウチュウ">焼酎</option>
                        </datalist>
                    </div>
                    <div>
                        割りもの: <input type="text" name="w" list="warimono">
                        <datalist id="warimono">
                            <option value="ソーダ">ソーダ</option>
                            <option value="トニックウォーター">トニックウォーター</option>
                            <option value="ジンジャエール">ジンジャエール</option>
                            <option value="オレンジジュース">オレンジジュース</option>
                            <option value="グレープフルーツジュース">グレープフルーツジュース</option>
                            <option value="パイナップルジュース">パイナップルジュース</option>
                            <option value="トマトジュース">トマトジュース</option>
                            <option value="ギュウニュウ">牛乳</option>
                        </datalist>
                    </div>
                    <div>
                        テイスト: <input type="text" name="t" list="taste">
                        <datalist id="taste">
                            <option value="辛口">辛口</option>
                            <option value="甘辛">中辛甘口</option>
                            <option value="甘口">甘口</option>
                        </datalist>
                    </div>
                    <div>
                        <input type="submit" value="検索">
                    </div>
                </fieldset>

            </form>
        </div>
        <div class="tab_content" id="programming_content">
            <!-- プログラミングの内容がここに入ります -->
            <fieldset>
                <legend>登録メニュー表</legend>
                <table>
                    <thead>
                        <tr>
                            <th>名前</th>
                            <th>ベース</th>
                            <th>割りもの</th>
                            <th>味わい</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- ここに<tr><td>deadline</td><td>todo</td><tr>の形でデータが入る -->
                        <?= $output ?>
                    </tbody>
                </table>
            </fieldset>


        </div>
        <div class="tab_content" id="design_content">
            <!-- デザインの内容がここに入ります -->


        </div>


</body>

</html>