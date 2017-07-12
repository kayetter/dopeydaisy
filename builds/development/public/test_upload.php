
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>

<?php
$_SESSION["message"] = "";
if(!empty($_GET["user_id"])){
  global $errors;
  $user_id = $_GET["user_id"];
  $user_record = find_user_by_id($user_id);
  $username = $user_record["username"];
  $user_type = find_user_type_by_user_id($user_id);
  $user_unique_id = substr($user_record["user_unique_id"],0,8);
  //set isProd or isDev variables dopeydaisy.dev = dev environment. //dopeydaisy.com if production
  $env = $_SERVER["HTTP_HOST"];
    if($env=="dopeydaisy.dev"){
      $isDev = true;
      $isProd = false;
    } elseif($env=="dopeydaisy.com"){
      $isProd = true;
      $isDev - false;
    }

    if($isDev){
      $dc_root = "C:/Users/kasch/Documents/2016_Web_development/MySites/drd.cards/builds/development/";
    }
    if($isProd){
      $dc_root = "/home2/kayetter/public_html/drd.cards/";
    }

} else {
  //if no $GET_variables then return to login page
  redirect_to("login.php");
}

if(isset($_POST["submit"])){
  $drdcard = strtolower(mysql_prep($_POST["drdcard"]));
  $drdpin = mysql_prep($_POST["drdpin"]);
  $hashed_drdpin = password_hash($drdpin,PASSWORD_DEFAULT);
  $og = $_POST["og"];
  $og_title = $_POST["og"]["title"];
  $og_desc = $_POST["og"]["desc"];

  $vcard_dir = $dc_root."vcards/";
  $bizimg_dir = $dc_root."bizimg/";
  $drdcard_dir = $dc_root;

  $files = $_FILES;
  $errors = array();
  $max_file_size = 1500000;

  //if file upload process in POST returned no errors
  if($files["vcard"]["error"]==UPLOAD_ERR_OK  && $files["bizimg"]["error"]==UPLOAD_ERR_OK ){
    //add target path to file array
    //create_new_filename will keep generating uuid and checking if file exists until it doesn't -- love this function
    $vcard_new_path = create_new_filename($vcard_dir, $files["vcard"]["name"]);
    $bizimg_new_path = create_new_filename($bizimg_dir, $files["bizimg"]["name"]);

    $files["vcard"]["new_path"] = $vcard_new_path;
    $files["bizimg"]["new_path"] = $bizimg_new_path;
    $vcard = $files["vcard"];
    $bizimg = $files["bizimg"];

    //for drdcard keep path relative to drd.cards domain and new file (trimming of the root directory)
    if($isDev){
      $bizimg_og_dir = "bizimg/";
    }

    if($isProd){
      $bizimg_og_dir = "http://drd.cards/bizimg/";
    }

    $vcard_drdcard_path = "vcards/".pathinfo($vcard_new_path,PATHINFO_FILENAME).".".pathinfo($vcard_new_path,PATHINFO_EXTENSION);
    $bizimg_drdcard_path = $bizimg_og_dir.pathinfo($bizimg_new_path,PATHINFO_FILENAME).".".pathinfo($bizimg_new_path,PATHINFO_EXTENSION);

    //validate files
    //validate .vcf, .jpg, .gif, png extensions

    $formOK = validate_extensions($files);

    //validate that file is an image
    if($formOK){
      $formOK = validate_image($bizimg);
    }

    //validate that file is .vcf
    if($formOK){
      $formOK = validate_vcard($vcard);
    }
    //validate that display_name by user combination doesn't already exist
    if($formOK){
      $formOK = validate_dup_filenames($files, $user_id);
    }
    //validate that drdcard does not already exist.
    if($formOK){
      $formOK = validate_dup_record($drdcard, "bizcard","drdcard");
    }
        //if all errors are empty then process files
    if($formOK){
      //move files to target directory and filename
      $user_bizcard_id = create_file_records($files, $user_id, $og, $max_file_size, $bizimg_dir);

      if($user_bizcard_id){
        //with new $user_bizcard_id_create association bizcard record
          $bizcard_id = create_bizcard_record($user_bizcard_id, $drdcard, $drdpin);
        }
        //create bizcard content
      if($bizcard_id){
        $drdcard_content = build_bizcard_output(
          $drdcard,
          $vcard_drdcard_path,
          $bizimg_drdcard_path,
          $og_title,
          $og_desc
        );
      }
      if($drdcard_content){
        //create drdcard in bizcard directory
        file_put_contents($drdcard_dir.$drdcard.".php", $drdcard_content);
      } else {$_SESSION["message"] .= "there is no DRD content";}
    }
      else {
      print_r($errors);

    } //end of is form ok
 } else {
    check_file_errors($files);

  }//end of upload error condtional

}//end of post submit conditional


 ?>
 <?php echo form_errors($errors);
   if(isset($_SESSION["message"])){
     print_r($_SESSION["message"]);
     }
   echo "formOK: ";
   if($formOK){echo "true<br>";}else{echo "false<br>";}

  //  echo "drdcard_redirect: ".$drd_redirect;
   $_SESSION["message"] = null;

   if(isset($user_bizcard_id)){ echo "user_bizcard_id".$user_bizcard_id;}
   ?>
<pre>
  <?php
  print_r($_FILES);
  print_r($_POST);
  print_r($og);
   ?>

</pre>


<?php
 if (isset($connection)) {
   mysqli_close($connection);
 }
  // 5. Close database connection
?>
