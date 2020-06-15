<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ホストユーザ登録画面</title>
</head>

<body>
    <form action="user_register_act.php" method="POST">
        <fieldset>
            <legend>カクテル検索ベースホストユーザ登録画面</legend>
            <div>
                user_id: <input type="text" name="user_id">
            </div>
            <div>
                password: <input type="text" name="password">
            </div>
            <div>
                <button>Register</button>
            </div>
            <a href="host_login.php">or login</a>
        </fieldset>
    </form>

</body>

</html>