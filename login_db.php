<?php

$url = "localhost";
$user = "ken";
$pass = "dbuser";
$db = "dbserver";

//SQLインジェクション対策
$input_id = htmlspecialchars($_GET['login_id'], ENT_QUOTES);
$input_pass = htmlspecialchars($_GET['login_pass'], ENT_QUOTES);

// 接続(DB選択含む)
$link = mysqli_connect($url,$user,$pass,$db);

/* 接続状況をチェック */
if (!$link) {
	die('接続失敗です。'.mysqli_connect_error());
	exit();
}

// 文字化け防止
mysqli_set_charset($link,"utf8");

// 実行
$query = "SELECT Password FROM Admin_User WHERE Admin_Id = ? ";

/* プリペアドステートメントを作成 */
$stmt = mysqli_prepare($link, $query);

/* マーカにパラメータをバインド(入れる)　"s"はString */
mysqli_stmt_bind_param($stmt, "s", $input_id);

/* クエリを実行 */
if(mysqli_stmt_execute($stmt)){
	// ステートメントの情報を変数に入れる（バインド）
	mysqli_stmt_bind_result($stmt, $id, $password);

	//mysqli_stmt_fetchすることで変数に入る
	mysqli_stmt_fetch($stmt);
	
} else {
	header("Location: index.php");
	exit();
}
// ステートメントを閉じる
mysqli_stmt_close($stmt);

//切断
mysqli_close($link);

header("Location: menu.php");
exit();
?>
