<?php
session_start();
$dsn = "mysql:dbname=php_tools;host=localhost;charset=utf8mb4";
$username = "root";
$password = "";

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

    $sql = "SELECT * FROM users WHERE id = :id";
    $stmt = $dbh->prepare($sql);
    $id = $_POST['id'];
    $pass = $_POST['pass'];
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $member = $stmt->fetch(PDO::FETCH_ASSOC);



if (password_verify($pass, $member['pass'])) {
    $_SESSION['id'] = $member['id'];
    $_SESSION['name'] = $member['name'];
    $msg = 'ログインしました。';
    $link = '<a href="memo.php">ホーム</a>';
    echo $msg;
    echo $link;
} else {
    $msg = 'IDもしくはパスワードが間違っています。';
    $link = '<a href="login_form.php">戻る</a>';
    echo $msg;
    echo $link;
}?>
