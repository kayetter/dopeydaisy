<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>
<?php
// if(isset($_GET)){
  $drdpin = "rock1";
  $drdcard= "kristin.yetter";
  $domain= $_SERVER["HTTP_HOST"];
  $uri = $_SERVER["REQUEST_URI"];
  $drdcard= $_SERVER["SCRIPT_NAME"];
  //get bizcard record
  $bizcard_record = find_record_by_field($drdcard, "bizcard", "drdcard");

  verify pin
  $hashed_pin = $bizcard_record["hashed_pin"];
  if($pin_verify=password_verify($drdpin, $hashed_pin)){

    $og_url = "https://{$domain}/{$uri}";
    $user_bizcard_id = $bizcard_record["user_bizcard_id"];
    $bizcard_content = get_bizcard_items(14);
    $bizimg = $bizcard_content["bizimg"];
    $vcard = $bizcard_content["vcard"];
    $og_title = "put title here";
    $og_desc = "";
  }// end of if password verified
    else {
      //if pin did not validate
      redirect_to("https://dopeydaisy.com/no_pin/");}
} else {
  //not a GET request
  redirect_to("https://dopeydaisy.com/no_pin/");}
 ?>

<!DOCTYPE html>

<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <!-- this viewport tag solves some of the problems associated with orientation change-->
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title><?php echo $drdcard; ?></title>

    <!-— facebook open graph tags -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?php echo "https:/drd.cards/".$drdcard?>" />
    <meta property="og:title" content="<?php echo $og_title; ?>" />
    <meta property="og:description" content="<?php echo $og_desc; ?>" />
    <meta property="og:image" content="<?php  echo $bizimg; ?>" />

</head>

  <body>
 <img style="100%; max-width: 600px; margin: auto;" src="<?php echo $bizimg; ?>" alt="<?php echo "{$drdcard}'s business card image'" ?>">
    <a href="<?php echo $vcard ?>"> download contact </a>

  <script src="js/jquery.js"></script>

  <?php
  if (stristr($_SERVER['HTTP_USER_AGENT'],'mobi')!==FALSE) {
      echo   "<script type=\"text/javascript\">
          $(document).ready(function(){
            window.location.href = '<?php echo {$vcard}; ?>';
          });
        </script>;";
  }
  ?>


</body>

</html>
<?php
 if (isset($connection)) {
   mysqli_close($connection);
 }
?>
