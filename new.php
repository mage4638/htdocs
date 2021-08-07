<html>
    <head>
        <link rel="stylesheet" type="text/css" href="memo.css">
        <meta charset="utf-8">
        <title>ログイン</title>
      </head>
      <body>
              <h1>新規会員登録</h1>
      <form action="register.php" method="post">
      <div>
        <label>名前：<label>
        <input type="text" name="name" required>
      </div>
      <div>
        <label>ID(数字を20文字以内)：<label>
        <input type="text" name="id" required>
      </div>
      <div>
        <label>パスワード：<label>
        <input type="password" name="pass" required>
      </div>
      <input type="submit" value="新規登録">
      </form>
</html>
