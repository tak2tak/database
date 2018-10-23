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

			if(isset($_POST[delete]) === true) {
				$name = $_POST[name];
				$contents = $_POST[contents];
                $id = $_POST[id];

				if($name !=='' && $contents !=='') {
					$query =  "DELETE FROM dbtable "
                        ." WHERE id = "
                        .mysqli_real_escape_string($link, $id);
                    
					$res = mysqli_query($link, $query);
					
					if($res !== false) {
						$msg = "削除に成功しました。一覧へ戻ってください。";
					} else {
						$err_msg = "削除に失敗しました";
					}
				} else {
					$err_msg = "ID番号と名前とコメントを記入してください";
				}
			}

			$query ="SELECT id, name, contents FROM dbtable";
			$res = mysqli_query($link, $query);
			$data = array();
			while ($row=mysqli_fetch_assoc($res)) {
				array_push($data, $row);
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
            <h1>コメント削除</h1>
            <div class="row1">
                
                <form method="post" action="database_delete.php">
                    ID<input type="text" name="id" rows="1" cols="2" value="<?= $_POST['id']?>">
                    名前<input type="text" name="name" value="<?= $_POST['name']?>"><br>
                    コメント<textarea name="contents" rows="2" cols="30"><?= $_POST['contents']?></textarea>
                    <input type="submit" name="delete" value="削除">
                </form>
                <br>
                <?= $msg ?>
                <?= $error_msg ?>
                <br><br>
                <a href="database_index.php">一覧へ戻る</a><br>
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