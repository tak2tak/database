<?php

    $db_host='localhost';
    $db_name='db_db';
    $db_user='db_user';
    $db_pass='db_pass';

    $id = $_POST['id'];

    //データベース接続
    $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

		if($link !== false) {
			$msg = '';
			$err_msg = '';
            

			if(isset($_POST[update]) === true) {
				$name = $_post['name'];
				$contents = $_post['contents'];


				if($name !=='' && $contents !=='') {
                    $query = "UPDATE dbtable SET name ="
                        ."{$name}"
                        .", contents = "
                        ."{$contents}"
                        ." WHERE id = "
                        ."{$id}";
                    
                    
					$res = mysqli_query($link, $query);
					
					if($res !== false) {
						$msg = "書き込みに成功しました";
					} else {
						$err_msg = "書き込みに失敗しました";
					}
				} else {
					$err_msg = "名前とコメントを記入してください";
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
                
                <br>
                <a href="database_index.php">一覧へ戻る</a><br>
                <br>
                <br>
                <?= var_dump($_POST['id']) ?><br><br>
                <?= var_dump($_POST['name']) ?><br><br>
                <?= var_dump($_POST['contents']) ?><br><br>
                <?= var_dump($id) ?>

            </div>
        </div>
    </body>
</html>