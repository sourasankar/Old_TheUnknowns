<?php
session_start();
$user=$_SESSION["user"];
$target_dir = "../profile_pic/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
switch($imageFileType){
	case 'jpg':	
		$image=imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
		break;
	case 'jpeg':		
		$image=imagecreatefromjpeg($_FILES["fileToUpload"]["tmp_name"]);
		break;
	case 'png':		
		$image=imagecreatefrompng($_FILES["fileToUpload"]["tmp_name"]);
		break;
}





$thumb_width = 1500;
$thumb_height = 1500;
$width = imagesx($image);
$height = imagesy($image);
$original_aspect = $width / $height;
$thumb_aspect = $thumb_width / $thumb_height;
if ( $original_aspect >= $thumb_aspect )
{
   // If image is wider than thumbnail (in aspect ratio sense)
   $new_height = $thumb_height;
   $new_width = $width / ($height / $thumb_height);
}
else
{
   // If the thumbnail is wider than the image
   $new_width = $thumb_width;
   $new_height = $height / ($width / $thumb_width);
}
$thumb = imagecreatetruecolor( $thumb_width, $thumb_height );
// Resize and crop
imagecopyresampled($thumb,
                   $image,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);
imagejpeg($thumb,$target_dir.$user.".jpg", 80);
    
$random=rand(0,99999999);
imagedestroy($image);








require "conn.php";
$sql = "UPDATE players_details SET pic='$user', pic_cache='$random' WHERE username='$user'";
$conn->query($sql);
$conn->close();

header("Location: ../logged.php");
	die();

?>