<?php 
session_start(); 
if (!isset($_SESSION["user"])) {
	header("Location: login.php");
	die();
}
$user=$_SESSION["user"];

require "php/conn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST"){

	$ign=$_POST["ign"];
	$color=$_POST["color"];


	$sql = "UPDATE players_details SET ign='$ign',color='$color' WHERE username='$user'";
	$conn->query($sql);
	$status="success";
	$msg="Updated Successfully";
}
	$purple=$blue=$green=$yellow=$orange=$defaultcol=null;
	$sql = "SELECT ign,color,pic,pic_cache FROM players_details WHERE username='$user'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$ign=$row["ign"];
	$color=$row["color"];
	switch ($color) {
		case '#803ca1':
			$purple="checked";
			break;
		case '#eda338':
			$orange="checked";
			break;
		case '#109856':
			$green="checked";
			break;
		case '#68a3e5':
			$blue="checked";
			break;
		case '#f1d800':
			$yellow="checked";
			break;		
		default:
			$defaultcol="checked";
			break;
	}


?>

<!DOCTYPE html>
<html>
<head>
	<title><?php echo $_SESSION["user"] ?></title>
	<?php require "php/head.php" ?>
</head>
<body>

	<?php require "php/nav.php" ?>


	<div class="panel panel-primary" style="margin: 100px auto 0 auto; width: 300px;">
		<div class="panel-heading">
			<h3 class="panel-title">PROFILE PICTURE</h3>
		</div>
		<div class="panel-body">
			<div style="text-align: center;">
				<div class="form-group">
					<img class="logo2" src="profile_pic/<?php echo $row["pic"].".jpg?".$row["pic_cache"]; ?>" style="width: 40%;" >
				</div>
			</div>

			<form action="php/upload.php" method="post" enctype="multipart/form-data">
				<div class="form-group">
					<label>Profile Picture</label>
					<input type="file" accept=".jpg,.png,.jpeg" name="fileToUpload" id="fileToUpload">
				</div>
				<div class="alert alert-danger" style="margin: 10px 0; padding: 1px;" role="alert"><b>Note: Upload only 1:1 (square) Cropped Image for Better Result</b></div>
				<div class="form-group">
					<button type="submit" class="btn btn-primary">Upload Image</button>
				</div>  			
    			
			</form>
		</div>
	</div>


	<div class="panel panel-primary" style="margin: 30px auto; width: 300px;">
		<div class="panel-heading">
			<h3 class="panel-title">SET DETAILS</h3>
		</div>
		<div class="panel-body"> 
			
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<div class="form-group">
					<label>IGN</label>
					<input type="text" value="<?php echo $ign ?>" class="form-control" placeholder="IGN"  name="ign" required>
				</div>
				<label>COLOR</label>
				<div class="form-check">
	  				<input class="form-check-input" type="radio" name="color" id="radiobutton1" value="" <?php echo $defaultcol; ?>>
	  				<label class="form-check-label" for="radiobutton1">No Color</label>
				</div>
				<div class="form-check">
	  				<input class="form-check-input" type="radio" name="color" id="radiobutton2" value="#803ca1" <?php echo $purple; ?>>
	  				<label class="form-check-label" for="radiobutton2">Purple</label>
				</div>
				<div class="form-check">
	  				<input class="form-check-input" type="radio" name="color" id="radiobutton3" value="#eda338" <?php echo $orange; ?>>
	  				<label class="form-check-label" for="radiobutton3">Orange</label>
				</div>
				<div class="form-check">
	  				<input class="form-check-input" type="radio" name="color" id="radiobutton4" value="#109856" <?php echo $green; ?>>
	  				<label class="form-check-label" for="radiobutton4">Green</label>
				</div>
				<div class="form-check">
	  				<input class="form-check-input" type="radio" name="color" id="radiobutton5" value="#68a3e5" <?php echo $blue; ?>>
	  				<label class="form-check-label" for="radiobutton5">Blue</label>
				</div>
				<div class="form-check">
	  				<input class="form-check-input" type="radio" name="color" id="radiobutton6" value="#f1d800" <?php echo $yellow; ?>>
	  				<label class="form-check-label" for="radiobutton6">Yellow</label>
				</div>

				<button type="submit" class="btn btn-primary">Update</button>
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
<?php 
$status=$msg=null;
$conn->close(); ?>