<?php
session_start();
$_SESSION = array();
session_destroy();
?>

<p>ログアウトしました。</p>
<a href="memo.php">メインページへ</a>
