<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php


// function validate_img_size($bizimg, $size, $quality){
//   $filename = $_FILES["file"]["tmp_name"];
//   $dir = 'C:/Users/kasch/Documents/2016_Web_development/MySites/dopeydaisy/extra/kristin_yetter/';
//   $new_filename = $dir.'resized_bizimg.jpg';
//   $bizimg_temp = $dir.'bizimg_temp.jpg';
//
//   global $errors;
//   if($bizimg["size"] > $size && strpos($bizimg["type"], "image") !== false){
//       $result = move_uploaded_file($filename, $bizimg_temp.".jpg");
//       if(!$result){ $errors["file-move"] = "could not move file";} else {
//           $i = 1;
//           $continue = true;
//           $file = $bizimg_temp;
//           while($continue == true){
//           $new_img = compress_image($file, $new_filename, $quality);
//           if(filesize($new_img) < $size){$continue = false; unlink($bizimg_temp); return $new_img;}
//           unlink($new_filename);
//           $quality = $quality - 10;
//           $i++;
//           } //end while loop
//
//           }
//         }
//
//     else {
//       $result = move_uploaded_file($bizimg["tmp_name"], $unsized);
//         if(!$result){$errors["file-move"] = "could not move file"; return null;} else {
//             return $unsized;
//         }
//     }
// }
global $errors;
$error = "";
	if ($_POST) {


    $img = getimagesize($_FILES["file"]["tmp_name"]);


    		if ($_FILES["file"]["error"] > 0) {
        			$error = $_FILES["file"]["error"];
    		}
    		else if (($_FILES["file"]["type"] == "image/gif") ||
			($_FILES["file"]["type"] == "image/jpeg") ||
			($_FILES["file"]["type"] == "image/png") ||
			($_FILES["file"]["type"] == "image/pjpeg")) {

        $new_img = validate_img_size($_FILES["file"],  1500000, 90, 'C:/Users/kasch/Documents/2016_Web_development/MySites/dopeydaisy/extra/kristin_yetter/');
              //
  			// $filename = compress_image($_FILES["file"]["tmp_name"], $url, 80);
              //
              // move_uploaded_file($filename, $url);
        			// $buffer = file_get_contents($url);

      //   			/* Force download dialog... */
      //   			header("Content-Type: application/force-download");
      //   			header("Content-Type: application/octet-stream");
      //   			header("Content-Type: application/download");
      //
			// /* Don't allow caching... */
      //   			header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
      //
      //   			/* Set data type, size and filename */
      //   			header("Content-Type: application/octet-stream");
      //   			header("Content-Transfer-Encoding: binary");
      //   			header("Content-Length: " . strlen($buffer));
      //   			header("Content-Disposition: attachment; filename=$url");

        			/* Send our file... */
        			// echo $buffer;
    		}else {
        			$error = "Uploaded image should be jpg or gif or png";
    		}
	}
?>
<html>
    	<head>
        		<title>Php code compress the image</title>
    	</head>
    	<body>
<pre>
<?php
print_r($_FILES);
if(isset($img)){
  print_r($img);
}

echo "errors:<br>";
print_r($errors);

if(isset($new_img)){
  print_r(getimagesize($new_img));
  echo "new_image";
  echo $new_img."<br>";
  echo filesize($new_img);
} else {echo "new image not created";}
 ?>
</pre>
		<div class="message">
                    	<?php
                    		if($_POST){
                        		if ($error) {
                            		?>
                            		<label class="error"><?php echo $error; ?></label>
                        <?php
                            		}
                        	}
                    	?>
                	</div>
		<fieldset class="well">
            	    	<legend>Upload Image:</legend>
			<form action="run_fxns.php" name="myform" id="myform" method="post" enctype="multipart/form-data">
				<ul>
			            	<li>
						<label>Upload:</label>
			                                <input type="file" name="file" id="file"/>
					</li>
					<li>
						<input type="submit" name="submit" id="submit" class="submit btn-success"/>
					</li>
				</ul>
			</form>
		</fieldset>
	</body>
</html>
