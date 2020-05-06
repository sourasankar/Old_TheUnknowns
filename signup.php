<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	$fname=strtolower($_POST["fname"]);
	$lname=strtolower($_POST["lname"]);
	$dob=$_POST["dob"];
	$phone=$_POST["phone"];
	$email=strtolower($_POST["email"]);
	$uname=strtolower($_POST["uname"]);
	$pass=md5($_POST["pass"]);
	$cpass=md5($_POST["cpass"]);

	//connection to db

	require "php/conn.php";

	//check for username already taken

	$sql = "SELECT username,email FROM players_credentials";
	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()){
		if($row["username"]==$uname  || $row["email"]==$email){
			$flag=1;
			break;
		}
	}


	if(isset($flag)){
		$flag=null;
		$status="danger";
		$msg="The User Name You Have Entered is Already Taken or The Email is Already Registered";
	}
	else{
		if ($pass==$cpass) {
			//inserting new account
			$sql = "INSERT INTO players_credentials(`username`, `pass`, `firstname`, `lastname`, `email`, `dob`, `phone`, `verified`) VALUES ('$uname','$pass','$fname','$lname','$email','$dob','$phone',FALSE)";
			$conn->query($sql);
    		$link=md5($uname);
    		/*$htmlStr = "";
            $htmlStr .= "Hi $uname,<br /><br />"; 
            $htmlStr .= "Please click the button below to verify your Account.<br /><br /><br />";
            $htmlStr .= "<a href='https://kootty420.live/verify.php?verify=$link' target='_blank' style='padding:1em; font-weight:bold; background:#8e44ad; color:#fff;text-decoration: none;'>VERIFY ACCOUNT</a><br /><br /><br />"; 
            $htmlStr .= "Kind regards,<br />";
            $htmlStr .= "<a href='https://kootty420.live' target='_blank'> Th€ Unknow$</a><br />";
 
       
            $headers  = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
            $headers .= "From: Th€ Unknow$  <no-reply@kootty420.live> \n";
 
            $body = $htmlStr;

		    mail("$email","Verify | Th€ Unknow$",$body,$headers);*/
		    
		    require 'phpmailer/PHPMailerAutoload.php';
            $mail = new PHPMailer;
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Host = 'smtp.hostinger.in';
            $mail->Port = 587;
            $mail->SMTPAuth = true;
            $mail->Username = 'support@kootty420.live';
            $mail->Password = 'KSS103003#';
            $mail->setFrom('support@kootty420.live', 'The Unknowns');
            $mail->addReplyTo('support@kootty420.live', 'The Unknowns');
            $mail->addAddress("$email","$fname"." "."$lname");
            $mail->Subject = 'Verification';
            $htmlStr = "";
            $htmlStr .= "Hi $uname,<br /><br />"; 
            $htmlStr .= "Please click the button below to verify your Account.<br /><br /><br />";
            $htmlStr .= "<a href='https://kootty420.live/verify.php?verify=$link' target='_blank' style='padding:1em; font-weight:bold; background:#8e44ad; color:#fff;text-decoration: none;'>VERIFY ACCOUNT</a><br /><br /><br />"; 
            $htmlStr .= "Kind regards,<br />";
            $htmlStr .= "<a href='https://kootty420.live' target='_blank'> Th€ Unknow$</a><br />";
            $mail->msgHTML($htmlStr);
            $mail->send();
		
    		$fname=$lname=$dob=$phone=$email=$uname=$pass=$cpass=$msg=$flag=null;
			$status="success";
			$msg="Verification Link has been Sent to Your Email. <b>**It may take upto 10 Minutes**</b>";
			
		}
		else{
			$status="danger";
			$msg="Confirm Password Do Not Match";
		}
	}

	//connection to db close
	$conn->close();
}
else{
	$fname=$lname=$dob=$phone=$email=$uname=$pass=$cpass=$msg=$flag=null;	
}
	

?>


<!DOCTYPE html>
<html>
<head>
	<title>Signup</title>
	<?php require "php/head.php" ?>
</head>
<body>
	<?php require "php/nav.php" ?>

	
	<div class="panel panel-primary" style="margin: 100px auto; width: 300px;">
		<div class="panel-heading">
			<h3 class="panel-title">REGISTER</h3>
		</div>
		<div class="panel-body">
		<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group">
				<label>First Name</label>
				<input type="text" class="form-control" value="<?php echo $fname ?>" placeholder="Enter First Name" name="fname" required>
			</div>
			<div class="form-group">
				<label>Last Name</label>
				<input type="text" class="form-control" value="<?php echo $lname ?>" placeholder="Enter Last Name" name="lname" required>
			</div>
			<div class="form-group">
				<label>Date of Birth</label>
				<input type="date" class="form-control" value="<?php echo $dob ?>" name="dob" required>
			</div>
			<div class="form-group">
				<label>Phone No</label>
				<input type="tel" class="form-control" value="<?php echo $phone ?>" placeholder="Phone No" name="phone" pattern="[0-9]{10}" title="Input Valid Phone No"  required>
			</div>
			<div class="form-group">
				<label>Email Address</label>
				<input type="email" class="form-control" value="<?php echo $email ?>" placeholder="Enter email" name="email" required>
			</div>
			<div class="form-group">
				<label>User Name</label>
				<input type="text" class="form-control" value="<?php echo $uname ?>" placeholder="User Name" name="uname" required>
			</div>
			<div class="form-group">
				<label>Password</label>
				<input type="password" class="form-control" pattern=".{4,15}" title="Password should be 4-15 length" placeholder="Password" name="pass" required>
			</div>
			<div class="form-group">
				<label>Confirm Password</label>
				<input type="password" class="form-control" pattern=".{4,15}" title="Password should be 4-15 length" placeholder="Confirm Password" name="cpass" required>
			</div>
			<div class="form-group form-check">
				<input type="checkbox" class="form-check-input" id="checkbox1" required>
				<label class="form-check-label" for="checkbox1">I Agree to Submit My Info</label>
			</div>
			<button type="submit" class="btn btn-primary">Sign up</button>
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