<?php
if (isset($_GET["verify"])){
 	
 	$verify=$_GET["verify"];

 	require "php/conn.php";

 	$sql = "SELECT username FROM players_credentials WHERE verified=FALSE";
 	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if(md5($row["username"])==$verify){
			$flag=1;
			$user=$row["username"];
			break;
		}
	}
	if(isset($flag)){
		$flag=null;
		$sql = "UPDATE players_credentials SET verified=TRUE WHERE username='$user'";
		$conn->query($sql);
		$sql = "INSERT INTO players_details(`username`,`pic`) VALUES ('$user','logo')";
		$conn->query($sql);		
		mkdir("pic_folder/$user");
		$status="success";
		$msg="Account Succesfully Verified. <a href='login.php'><b>Login</b></a>";
		
	}
	else{
		$sql = "SELECT username FROM players_credentials WHERE verified=TRUE";
 		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			if(md5($row["username"])==$verify){
				$flag=1;
				break;
			}
		}
		if(isset($flag)){
		$flag=null;	
		$status="success";
		$msg="Account Already Verified. <a href='login.php'><b>Login</b></a>";		
		}
		else{
			$status="danger";
			$msg="Account Vefication failed";
		}
	}

	$conn->close();

?>

<!DOCTYPE html>
<html>
<head>
	<title>Verify</title>
	<?php require "php/head.php" ?>
</head>
<body>

	<?php require "php/nav.php" ?>


	<div class="panel panel-primary" style="margin: 100px auto; width: 300px;">
		<div class="panel-heading">
			<h3 class="panel-title">VERIFICATION</h3>
		</div>
		<div class="panel-body">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<?php if(isset($msg)) echo '<div class="alert alert-'.$status.'" style="margin: 10px 0; padding: 1px;" role="alert">'.$msg.'</div>' ?>
		</form>
		</div>
	</div>



	<?php require "php/footer.php" ?>

</body>
</html>
<?php 
} 
else{
	header("Location: index.php");
	die();
}
?>