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

			if(isset($_POST['send']) === true) {
				$name = $_POST['name'];
				$contents = $_POST['contents'];

				if($name !=='' && $contents !=='') {
                    // 名前とコメントのINSERT文を格納
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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>
    <body>        
        <div class="container-fluid" bg-info>
            <div class ="row">
            <h1>コメント一覧</h1>
                <form class ="form-horizontal" method="post" action="">
                    <div class="form-group">
                        <label for = "name" class="control-label">名前:</label>
                            <input type="text" name="name" class="form-control">
                        <label for = "contents" class="control-label">コメント:  </label>
                            <input type="text" name="contents" class="form-control">
                        <input type="submit" class="col-sm-offset-2" name="send" value="書き込む">
                </form>
            </div>
        </div>
        <hr>
        
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
                     <input type="hidden" name="name" value="<?=$val['name']?>">
                    <input type="hidden" name="contents" value="<?=$val['contents']?>">
                </form>
            </td>
        </tr>
     <?php } ?>

</table>
        
		<!-- ここに書き込まれたデータ表示-->
        <BR>↓  var_dump表示　↓<br>
                <?= var_dump($_POST['id']) ?><BR><BR>
                <?= var_dump($_POST['name']) ?><BR><BR>
                <?= var_dump($_POST['contents']) ?><BR><BR>
                <?= var_dump($val['contents']) ?>
        
        <!--  ↓のちほど削除します 
                <?php
                if($msg !== '') echo '<p>'.$msg.'</p>';
                if($err_msg !== '') echo '<p style="color:#f00;">'.$err_msg.'</p>';
                    foreach($data as $key => $val) {
                        echo $val['id'].' '
                            .$val['name'].' '
                            .$val['contents'].' '                                .'<br>';
                    }
            ?>
        ここまで削除する-->
    </body>
</html>