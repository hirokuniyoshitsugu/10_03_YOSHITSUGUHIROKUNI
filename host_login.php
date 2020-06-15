<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>カクテル検索ベースログイン画面</title>
</head>

<body>
    <form action="host_login_act.php" method="POST">
        <fieldset>
            <legend>カクテル検索ベースホストユーザーログイン</legend>
            <div>
                user_id: <input type="text" name="user_id">
            </div>
            <div>
                password: <input type="text" name="password">
            </div>
            <div>
                <button>HOST Login</button>
            </div>
        </fieldset>
    </form>
    <br><br>
    <a href="user_register.php">新規登録</a>
    <a href="user_search.php">ゲスト</a>

</body>

</html>