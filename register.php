<?php
//フォームからの値をそれぞれ変数に代入
$dsn =  "mysql:dbname=php_tools;host=localhost;charset=utf8mb4";
$username = "root";
$password = "";
try {
    $dbh = new PDO($dsn, $username, $password);
    $name = $_POST['name'];
    $id = $_POST['id'];
    $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}

//フォームに入力されたmailがすでに登録されていないかチェック
$sql = "SELECT * FROM users WHERE id = :id";
$stmt = $dbh->prepare($sql);
$stmt->bindValue(':id', $id);
$stmt->execute();
$member = $stmt->fetch();
error_reporting(0);
if ($member['id'] === $id) {
    $msg = '同じidが存在します。';
    $link = '<a href="memo.php">戻る</a>';
    echo $member['id'];
} else {
    //登録されていなければinsert
    $sql = "INSERT INTO users(name, id, pass) VALUES (:name, :id, :pass)";
    $stmt = $dbh->prepare($sql);
    $stmt->bindValue(':name', $name);
    $stmt->bindValue(':id', $id);
    $stmt->bindValue(':pass', $pass);
    $stmt->execute();
    $msg = '会員登録が完了しました';
    $link = '<a href="login_form.php">ログインページ</a>';
}
?>

<h1><?php echo $msg; ?></h1><!--メッセージの出力-->
<?php echo $link; ?>
