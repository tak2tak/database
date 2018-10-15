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

			if(isset($_POST[send]) === true) {
				$name = $_POST[name];
				$contents = $_POST[contents];

				if($name !=='' && $contents !=='') {
					$query = "INSERT INTO dbtable("
					."name,"
					."contents"
					.")VALUES ("
					."'". mysqli_real_escape_string($link, $name)."',"
					."'". mysqli_real_escape_string($link, $contents)."'"
					.")";

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
            <h1>コメント削除</h1>
            <div class="row1">
                
                <form method="post" action="">
                        名前<input type="text" name="name" value="">
                        コメント<textarea name="contents" rows="4" cols="20"></textarea>
                    <input type="submit" name="send" value="編集">
                </form>
            </div>
        </div>
    </body>
</html>