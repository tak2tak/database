<?php

    $db_host='localhost';
    $db_name='db_db';
    $db_user='db_user';
    $db_pass='db_pass';

    $id = $_post[id];

    //データベース接続
    $link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

		if($link !== false) {
			$msg = '';
			$err_msg = '';
            

			if(isset($_POST[update]) === true) {
				$name = $_post[name];
				$contents = $_post[contents];


				if($name !=='' && $contents !=='') {
					$query = "Update dbtable set name="
                    ."'".mysqli_real_escape_string($link, $name)"',"
                    ."contents="
                    ."'". mysqli_real_escape_string($link, $contents)."' "
                    ."where id="
                    .$id;

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

            
			$query = "Update dbtable set name="
                    ."'".mysqli_real_escape_string($link, $name)"',"
                    ."contents="
                    ."'". mysqli_real_escape_string($link, $contents)."' "
                    ."where id="
                    .$id;
            
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
                        名前<input type="text" name="name" value="">
                        コメント<textarea name="contents" rows="4" cols="20"></textarea>
                    <input type="submit" name="update" value="編集">
                </form>
                <?= var_dump($_POST[id]) ?>
                <?= var_dump($_POST[name]) ?>
                <?= var_dump($_POST[contents]) ?>
                <?= var_dump($_val[contents]) ?>
                


            </div>
        </div>
    </body>
</html>