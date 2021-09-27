<html>
    <head>
        <link rel="stylesheet" type="text/css" href="memo.css">
        <meta charset="utf-8">
        <title>ログイン</title>
      </head>
      <h1>ログインページ</h1>
      <form action="login.php" method="post">
      <div>
          <label>ID：<label>
          <input type="text" name="id" required>
      </div>
      <div>
          <label>パスワード：<label>
          <input type="password" name="pass" required>
      </div>
      <input type="submit" value="ログイン">
      </form>
      <a href="memo.php">戻る</a>
</html>
