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
            <h1>コメント一覧</h1>            
                <form method="post" action="">
                        名前:<input type="text" name="name" value=""><br>
                        コメント:<textarea name="contents" ></textarea>
                    <input type="submit" name="send" value="書き込む">
                </form>
            </div>
        <hr>
        <?= var_dump($_POST[id]) ?>
                <?= var_dump($_POST[name]) ?>
                <?= var_dump($_POST[contents]) ?>
                <?= var_dump($_val[contents]) ?>
<table border='1'>
<tr>
    <td>id</td>
    <td>name</td>
    <td>コメント</td>
    <td>アクション</td>
    </tr>
<?php 
foreach($data as $key => $val){
 ?>
 
<tr> 
	<td><?=$val['id']?></td>
	<td><?=htmlspecialchars($val['name'], ENT_QUOTES, 'UTF-8')?></td>
    <td><?=$val['contents']?></td>
	<td>
		<form action="database_update.php" method="post">
            <input type="submit" value="編集">
            <input type="hidden" name="id" value="<?=$val['id']?>">
            <input type="hidden" name="name" value="<?=$val['name']?>">
            <input type="hidden" name="contents" value="<?=$val['contents']?>">
		</form>
        <form action="database_delete.php" method="post">
            <input type="submit" value="削除">
            <input type="hidden" name="id" value="<?=$val['id']?>">
		</form>
	</td>
</tr>
 
 <?php 
 } 
 ?>
 
</table>
        
		<!-- ここに書き込まれたデータ表示-->
            <?php
                if($msg !== '') echo '<p>'.$msg.'</p>';
                if($err_msg !== '') echo '<p style="color:#f00;">'.$err_msg.'</p>';
                    foreach($data as $key => $val) {
                        echo $val[id].' '
                            .$val['name'].' '
                            .$val['contents'].' '                                .'<br>';
                    }
            ?>
    </body>
</html>