<?php
	if($_POST["action"]=="submit") {
		session_start();
		if($_SESSION["verification"]==$_POST["in"]) {
			echo "!!!<br>";
		}
	}
?>
<form method="POST">
	<img src="verification.php"><br>
	<input type="text" name="in">
	<input type="hidden" name="action" value="submit">
	<button type="submit">送出</button>
</form>