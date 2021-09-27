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
            $stmt = $pdo->prepare("INSERT INTO subject2(mid,title,start,end,contents,URL) value (:mid,:title,:start,:end,:contents,:URL)"); //SQL文の骨子を準備
            $stmt->bindvalue(":mid", @$_POST["mid"]);
            $stmt->bindvalue(":title", @$_POST["title"]);
            $stmt->bindvalue(":start", @$_POST["start"]);
            $stmt->bindvalue(":end", @$_POST["end"]);
            $stmt->bindvalue(":contents", @$_POST["contents"]);
            $stmt->bindValue(":URL",@$_POST["URL"]);
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
    if($_SERVER['REQUEST_METHOD']==='POST'){

		header('Location:http://localhost/memo.php');//多重送信対策

	}
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
      error_reporting(0);
      if(isset($_SESSION['id'])):
        $a = $_SESSION['name'];
        $b = $_SESSION['id'];?>
        <div class="right">
        <span class="space">スケジュール表オンライン<br>ログイン <?php echo $b; echo " "; echo $a;?></span>
      </div>
    </header>
    <div  class="center">
    <span><?php echo $a; ?> さん ようこそ！</span>
  </div>
  <div class="side">
    <p class="menu">メニュー</p>
      <p>修正点は<a href="https://docs.google.com/forms/d/e/1FAIpQLSdEo71DQVzaxGToyquNxESUyObKrA_8Zhm2UNaGQd1IinKfww/viewform?usp=sf_link">こちら</a>にお願いします。</p>
      <p>新規にほしいものは<a href="https://docs.google.com/forms/d/e/1FAIpQLSf1AWTCpTnX-BNcfhKrFx0Qq_1bSh71dKzG0JI7kpG143_xGQ/viewform?usp=sf_link">こちら</a></p>
      <p>ログアウトは<a href="logout.php">こちら</a><p>
  </div>
        <!-- メモの新規作成フォーム -->
        <div class="main">
        <h1>スケジュール表<br></h1>
        <p>「締め切り」の欄に"yyyy-mm-dd" という形で日付を入力してください。<br> 予定の欄に内容を入力して下さい。</p>
        <p>残り日数が７日以下だと赤く表示されます。</p>


                <?php
                $to_day = new DateTime();
                $today = $to_day->format('Y-m-d');
                $today2 = new DateTime($today);
                $sql = "SELECT * FROM subject2 WHERE mid ='" . $b . "' ORDER BY title ";
                $sql2 = "SELECT * FROM subject2 WHERE mid ='" . $b . "'AND title ='" . $today ."'";
                $stmt=$pdo->query($sql2);
                $data = $stmt->fetchAll();



                if(!empty($data)):
                  $count = count($data);
                  ?>
                <p class="big">
                  <?php
                  echo "本日の予定";
                  echo "<br>";
                  for($i=0;$i<$count;$i++){
                    echo "・".$data[$i]["contents"];
                    echo "</br>";
                  } ?>
                </p>
              <?php else: ?>
                <p class="big">
                  <?php echo "本日の予定:なし"; ?>
                </p>
              <?php endif; ?>
                <div class="biside">

                  <form action="memo.php" method="post">
                      ID<br>
                      <input type="text" name="mid" size="20" value="<?php echo $b; ?>"></input><br>
                      締め切り(例:2000-01-01)<br>
                      <input type="text" name="title" size="20"></input><br>
                      開始時間<br>
                      <input type="text" name="start" size="20"></input><br>
                      終了時間<br>
                      <input type="text" name="end" size="20"></input><br>
                      内容<br>
                      <textarea name="contents" style="width:300px; height:100px;"></textarea><br>
                      URL<br>
                      <textarea name="URL" style="width:300px; height:100px;"></textarea><br>
                      <input type="submit" name="create" value="追加">
                  </form>

                <table border="2" width="40%" height="40%" class="table">
                  <caption>List</caption>
                <tr>
                  <th>日付</th>
                  <th>詳細<th>
                </tr>
                <?php if ($result = $pdo->query($sql)) {
                    //連想配列を取得
                    while ($row = $result->fetch()) {
                      $week = array( "日", "月", "火", "水", "木", "金", "土" );
                            $li_ne = new DateTime($row["title"]);
                            $line = $li_ne->format('Y-m-d');
                            $line2 = new DateTime($line);
                            if($yobi != $row["title"]):
                            $yobi = $row["title"];
                            $youbi = "(".$week[date("w",strtotime($yobi))].")";

                            $to_day = new DateTime();
                            $today = $to_day->format('Y-m-d');
                            $today2 = new DateTime($today);


                            ?>
                            <tr>
                              <td bgcolor="#d3d3d3"><?php echo $row["title"].$youbi;?></td>
                              <td><?php echo "<a href=schedule.php?title=".$row["title"].">".$row["title"]."の予定</a>";?></td>
                            </tr>
                          <?php elseif(empty($yobi)):
                            $yobi = $row["title"];
                            $youbi = "(".$week[date("w",strtotime($yobi))].")";

                            $to_day = new DateTime();
                            $today = $to_day->format('Y-m-d');
                            $today2 = new DateTime($today);

                            $count = $count + 1;
                          else:
                          endif;}
                        }else{

                        }?>
              </table>
            </br>

        </div>
      </div>

          <?php else:?>
            <p class="new"><a href="new.php">会員登録</a></p>
            <p class="login">すでに登録済みの方は<a href="login_form.php">こちら</a></p>
        </header>
            <h1>ログインしてください</h1>
            <p>会員登録してない方は会員登録をお願いします。<p>
            <?php endif;?>

</html>
