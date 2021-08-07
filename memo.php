<?php
    session_start();
    //まずはデータベースへ接続します
    $dsn = "mysql:dbname=php_tools;host=localhost;charset=utf8mb4";
    $username = "root";
    $password = "";
    $options = [];
    $pdo = new PDO($dsn, $username, $password, $options);
    date_default_timezone_set('Asia/Tokyo');
    //追加ボタンが押された時の処理を記述します。
    if (null !== @$_POST["create"]) { //追加ボタンが押され方どうかを確認
        if(@$_POST["title"] != "" AND @$_POST["contents"] != ""){ //メモが入力されているかを確認
              $deadline  = @$_POST["title"];
              $key = "-";
              if(strpos( $deadline, $key ) == true){
              list($year, $month, $day) = explode("-", $deadline);
              if (checkdate($month, $day, $year)){
            //メモの内容を追加するSQL文を作成し、executeで実行します。
            $stmt = $pdo->prepare("INSERT INTO subject2(mid,title,start,end,contents) value (:mid,:title,:start,:end,:contents)"); //SQL文の骨子を準備
            $stmt->bindvalue(":mid", @$_POST["mid"]);
            $stmt->bindvalue(":title", @$_POST["title"]); //:titleをpost送信されたtitleの内容に置換
            $stmt->bindvalue(":start", @$_POST["start"]);
            $stmt->bindvalue(":end", @$_POST["end"]);
            $stmt->bindvalue(":contents", @$_POST["contents"]); //:contentsをpost送信されたcontentsの内容に置換
            $stmt->execute(); //SQL文を実行
        } else {
              $alert = "<script type='text/javascript'>alert('エラー！　正しい日付を入力してください！');</script>";
              echo $alert;
            }
          }else{
            $alert = "<script type='text/javascript'>alert('エラー！　正しい日付を入力してください！');</script>";
            echo $alert;
          }
        }
      }
    //変更ボタンが押された時の処理を記述します。
    if($_SERVER['REQUEST_METHOD']==='POST'){

		header('Location:http://localhost/memo.php');

	}

?>
<html>
    <head>
        <link rel="stylesheet" type="text/css" href="memo.css">
        <meta charset="utf-8">
        <title>メモ</title>
        <link href="https://fonts.googleapis.com/css?family=M+PLUS+1p" rel="stylesheet">
        <!-- その他 head の内容は省略します -->
    </head>
    <body>
      <header>
          <p class="new"><a href="new.php">会員登録</a></p>
          <p class="login">すでに登録済みの方は<a href="login_form.php">こちら</a></p>
      </header>



      <?php
      if(isset($_SESSION['id'])):
        $a = $_SESSION['name'];
        $b = $_SESSION['id'];
        echo $a."さん、こんにちは。\n ID:".$b;?>
      <p>ログアウトは<a href="logout.php">こちら</a><p>
        <!-- メモの新規作成フォーム -->
        <h1>スケジュール表<br></h1>
        <p>「締め切り」の欄に"yyyy-mm-dd" という形で日付を入力してください。<br> 予定の欄に内容を入力して下さい。</p>
        <p>残り日数が７日以下だと赤く表示されます。</p>

        <form action="memo.php" method="post" class="sub_title">
            ID<br>
            <input type="text" name="mid" size="20" value="<?php echo $b; ?>"></input><br>
            締め切り(例:2000-01-01)<br>
            <input type="text" name="title" size="20" class="sub_title"></input><br>
            開始時間<br>
            <input type="text" name="start" size="20"></input><br>
            終了時間<br>
            <input type="text" name="end" size="20"></input><br>
            内容<br>
            <textarea name="contents" style="width:300px; height:100px;"></textarea><br>
            <input type="submit" name="create" value="追加">
        </form>
        <!-- 以下にメモ一覧を追加 -->
        <p class="sub_title">List</p>



                <?php  $sql = "SELECT * FROM subject2 WHERE mid ='" . $b . "' ORDER BY title ";?>


                <table border="2">

                  <th>締め切り</th>
                  <th>開始時間</th>
                  <th>終了時間</th>
                  <th>予定</th>
                  <th>残り日数</th>

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


                            ?>
                            <tr>
                              <td><?php echo $row["title"];?></td>
                              <td><?php if ($Stime == "00:00" && $Etime == "00:00"):
                                          echo " ";?></td>
                                <td><?php echo " " ?></td>
                              <?php else:
                                          echo $row["start"];?></td>
                                <td><?php echo $row["end"];?></td>
                              <?php endif; ?>
                              <td><?php echo $row["contents"]; ?> </td>
                              <td><?php if($number<=7){
                                                echo '<span style="background-color:#ff0000;color:#ffff00">'.$dif->format('%r %a day(s)').'</span>';
                                              }else{
                                                echo $dif->format('%r %a day(s)');
                                              }?> </td>
                              <td><?php echo "<a href=delete.php?id=" . $row["ID"] . ">削除</a>\n";?></td>
                            </tr>
                          <?php }
                        } ?>
              </table>
            </br>
          <?php else:?>
            <h1>ログインしてください</h1>
            <p>会員登録してない方は会員登録をお願いします。<p>
            <?php endif;?>

</html>
