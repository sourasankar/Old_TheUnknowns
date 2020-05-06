<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$uname=strtolower($_POST["uname"]);
	$pass=md5($_POST["pass"]);
	//connection to db

	require "php/conn.php";

	//check for username already taken

	$sql = "SELECT username FROM players_credentials WHERE verified=TRUE";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if($row["username"]==$uname){
			$flag=1;
			break;
		}
	}


	if(isset($flag)){
		$flag=null;
		$sql = "SELECT pass FROM players_credentials WHERE username='$uname'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		if ($row["pass"]==$pass) {
			//$status="success";
			//$msg="Successfully Logged In";
			session_start();
			$_SESSION["user"]=$uname;
			header("Location: logged.php");
			die();
		}
		else{
			$status="danger";
			$msg="Password Not Matched";
		}
	}
	else{
		$status="danger";
		$msg="User Name Not Found or Account Not Verified";
	}

	//connection to db close
	$conn->close();
}
else{
	$uname=$pass=$msg=$flag=null;	
}
	

?>


<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<?php require "php/head.php" ?>
</head>
<body>

	<?php require "php/nav.php" ?>

	<div class="panel panel-primary" style="margin: 100px auto; width: 300px;">
		<div class="panel-heading">
			<h3 class="panel-title">LOGIN</h3>
		</div>
		<div class="panel-body">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group">
				<label>User Name</label>
				<input type="text" class="form-control" placeholder="User Name" value="<?php echo $uname ?>" name="uname" required>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" pattern=".{4,15}" title="Password should be 4-15 length" placeholder="Password" name="pass" required>
			</div>
			<button type="submit" class="btn btn-primary">Login</button>
			<?php if(isset($msg)) echo '<div class="alert alert-'.$status.'" style="margin: 10px 0; padding: 1px;" role="alert">'.$msg.'</div>' ?>
		</form>
		</div>
	</div>





	<?php require "php/footer.php" ?>
	<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
	</script>

</body>
</html>