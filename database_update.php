<?php

    $db_host='localhost';
    $db_name='db_db';
    $db_user='db_user';
    $db_pass='db_pass';


    //データベース接続
    $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

		if($link !== false) {
			$msg = '';
			$err_msg = '';
            

			if(isset($_POST['update']) === true) {
				$name = $_POST['name'];
				$contents = $_POST['contents'];
                $id = $_POST['id'];
                

				if($name !=='' && $contents !=='') {
                    $query = "UPDATE dbtable SET name ="
                        ."'".mysqli_real_escape_string($link, $name)."',"
                        ."contents = "
                        ."'".mysqli_real_escape_string($link, $contents)."'"
                        ." WHERE id = "
                        .mysqli_real_escape_string($link, $id);
                    
                    
					$res = mysqli_query($link, $query);
					
					if($res !== false) {
						$msg = "編集に成功しました。一覧へ戻ってください。";
					} else {
						$err_msg = "編集に失敗しました";
					}
				} else {
					$err_msg = "名前とコメントを記入してください";
				}
			}

           

			arsort($data);
		} else {
			echo "データベースの接続に失敗しました";
		}

		//データベースへの接続閉じる
		mysqli_close($link);
?>
<!doctype html>
<html lang="jp"> 
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    </head>
    <body>
        <div class="container">
            <h1>コメント編集</h1>
            <div class="row1">
                
                <form method="post" action="database_update.php">
                    ID<input type="text" name="id" rows="1" cols="2" value="<?= $_POST['id']?>">
                    名前<input type="text" name="name" value="<?= $_POST['name']?>"><br>
                    コメント<textarea name="contents" rows="2" cols="30"><?= $_POST['contents']?></textarea>
                    <input type="submit" name="update" value="編集">
                </form>
                <?= $msg ?>
                <?= $error_msg ?>
                <br>
                <a href="database_index.php">一覧へ戻る</a><br>
                <br>
                <br>
                <?= var_dump($_POST['id']) ?><br><br>
                <?= var_dump($_POST['name']) ?><br><br>
                <?= var_dump($_POST['contents']) ?><br><br>
                <?= var_dump(mysqli_real_escape_string($link, $id)) ?><br><br>
                <?= var_dump(mysqli_real_escape_string($link, $name)) ?>
                

            </div>
        </div>
    </body>
</html>