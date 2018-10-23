# database

database_index.phpがメイン画面です。
updateとdeleteはそれぞれの画面に遷移して実行しています。


10月23日
SQL更新がうまくいかない原因は$_POSTが$_postになっていたのが原因でした。
Bootstrapをトップページに適用してます。
他のページも適用しようと思いましたがインフラテストもこなす必要が
あったため省いてます。

10月19日
database_update.phpの
SQL文「23~27行目」の文字列結合のミス？？が原因と考え
試行錯誤しましたが進めることができません...

database_delete.phpはまだ未完成です。
