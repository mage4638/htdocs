<?php
session_start();
$dsn = "mysql:dbname=php_tools;host=localhost;charset=utf8mb4";
$username = "root";
$password = "";
$pdo = new PDO($dsn, $username, $password);

try {
    $dbh = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    $msg = $e->getMessage();
}
  $a = $_SESSION['name'];
  $b = $_SESSION['id'];
  $c =  $_SERVER['REQUEST_URI'];

  $c = substr($c,-10);

  ?>
  <html>
      <head>
          <link rel="stylesheet" type="text/css" href="memo.css">
          <meta charset="utf-8">
          <title>メモ</title>
          <link href="https://fonts.googleapis.com/css?family=M+PLUS+1p" rel="stylesheet">
      </head>
      <body>
        <header>
            <a href="memo.php"><img src="アイコン.png" title="アイコン"></a>

        <?php
          $a = $_SESSION['name'];
          $b = $_SESSION['id'];?>
          <div class="right">
          <span class="space">スケジュール表オンライン<br>ログイン <?php echo $b; echo " "; echo $a;?></span>
        </div>
      </header>



  <?php  $sql = "SELECT * FROM subject2 WHERE title ='" . $c . "' AND mid ='" . $b . "'";
                $result = $pdo->query($sql);
                $row = $result->fetch();
                $counter = $result->rowCount();
                echo "<p class='number'>".$row["title"]."の予定は".$counter."件あります</p>";?>

                <div class="center">
                <a href="memo.php">戻る</a>
              </div>

  <?php if ($result = $pdo->query($sql)) {
      //連想配列を取得
      while ($row = $result->fetch()) {

        $li_ne = new DateTime($row["title"]);
        $line = $li_ne->format('Y-m-d');
        $line2 = new DateTime($line);

        $to_day = new DateTime();
        $today = $to_day->format('Y-m-d');
        $today2 = new DateTime($today);
        $dif = $today2->diff($line2);
        $number = $dif->format('%d');


        $Stime = $row["start"];
        $Etime = $row["end"];
        $week = array( "日", "月", "火", "水", "木", "金", "土" );
              $yobi = $row["title"];
              $youbi = "(".$week[date("w",strtotime($yobi))].")";
              ?>

              <table border="1" align="center" width="40%" height="40%" class="top">
                <tr><th bgcolor="#00AEEF">日付</th><td align="center"><?php echo "<p>".$row["title"].$youbi."</p>";?></td></tr>
                <?php if ($Stime == "" && $Etime == "" ):?>
                <?php elseif ($Stime == "00:00" && $Etime == "00:00" ):?>
                <?php else: ?>
                <tr><th bgcolor="#00AEEF">開始時間</th><td align="center"><?php echo "<p>".$row["start"]."</p>";?></td></tr>
                <tr><th bgcolor="#00AEEF">終了時間</th><td align="center"><?php echo "<p>".$row["end"]."</p>";?></td></tr>
                <?php endif; ?>
                <tr><th bgcolor="#00AEEF">内容</th><td align="center"><?php echo "<p>".$row["contents"]."</p>"; ?></td></tr>
                <?php if($number<=7):?>
                                  <tr><th bgcolor="#00AEEF">締め切り</th><td align="center"><?php echo '<span style="background-color:#ff0000;color:#ffff00">'.$dif->format('%r %a day(s)').'</span>'; echo "<br>";?></td></tr>
                                <?php else: ?>
                                  <tr><th bgcolor="#00AEEF">締め切り</th><td align="center"><?php echo '<p>締め切り:'.$dif->format('%r %a day(s)').'</p>';?>
                                <?php endif;?>
                              <?php if($row["URL"]==""): ?>
                <tr><th bgcolor="#00AEEF">URL</th><td align="center"><?php echo "<a>なし</a>"; echo "<br>"; ?></td></tr>
              <?php else: ?>
                <tr><th bgcolor="#00AEEF">URL</th><td align="center"><?php echo "<a href=".$row["URL"].">URL</a>"; echo "<br>"; ?></td></tr>
              <?php endif;?>
                <tr><th bgcolor="#00AEEF">削除</th><td align="center"><?php echo "<a href=delete.php?id=" . $row["ID"] . ">削除</a>\n";?></td></tr>
              </table>



      <?php
      }}else{

      }
?>
      <div class="center">
      <a href="memo.php">戻る</a>
    </div>
</html>
