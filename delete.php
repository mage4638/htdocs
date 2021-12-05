<?php

try{


    $stmt = $pdo->prepare('DELETE FROM subject2 WHERE ID = :id');

    $stmt->execute(array(':id' => $_GET["id"]));

    echo "完了";

  } catch (Exception $e) {
            echo 'error!' . $e->getMessage();
  }

?>

<!DOCTYPE html>
<html>
 <head>
   <meta charset="utf-8">
   <title>削除完了</title>
 </head>
 <body>
 <p>
     <a href="memo.php">元画面へ</a>
 </p>
 </body>
</html>
