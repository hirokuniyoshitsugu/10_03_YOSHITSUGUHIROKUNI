<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cakutel 検索サービス</title>
    <style>

    </style>
</head>

<body>
    <h1>カクテル 検索サービス</h1>
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

</body>

</html>