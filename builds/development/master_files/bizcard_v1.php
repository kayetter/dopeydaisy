<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>
<?php
// if(isset($_GET)){
  $drdpin = $_SERVER["QUERY_STRING"];
  $domain= $_SERVER["HTTP_HOST"];
  $uri = $_SERVER["REQUEST_URI"];
  $drdcard= $_SERVER["SCRIPT_NAME"];
  //get bizcard record
  $bizcard_record = find_record_by_field($drdcard, "bizcard", "drdcard");

  //verify pin
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

  $output = "";
  $output .=
  $output .="<!DOCTYPE html>";
  $output .= "<html lang=‘en’ prefix=‘og: http:\/\/ogp.me\/ns#’>";
  $output .= "<head>";
  $output .= "<meta charset=‘UTF-8’>";
  $output .= "<meta name=‘viewport’ content=‘user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width’>";
  $output .= "<meta name=‘apple-mobile-web-app-capable’ content=‘yes’>";
  $output .= "<meta http-equiv=‘X-UA-Compatible’ content=‘ie=edge’>";
  $output .= "<title>{$drdcard}</title>";
  $output .= "<!-— facebook open graph tags -->";
  $output .= "<meta property=‘og:type’ content=‘website’ />";
  $output .= "<meta property=‘og:url’ content=‘https://drd.cards/{$drdcard}?{$drdpin}’ />";
  $output .= "<meta property='og:title' content='{$og_title}' />";
  $output .= "<meta property=‘og:description’ content=‘{$og_desc}’ />";
  $output .= "<meta property=‘og:image’ content=‘{$bizimg}’ />";
  $output .= "<link rel=‘icon’ href=‘images/logos/Bee_SideRight.ico’ type=‘image/x-icon’>";
  $output .= "<link rel=‘stylesheet’ href=‘../css/lib-styles.css’>";
  $output .= "<link rel=‘stylesheet’ href=‘../css/style.css’>";
  $output .= "</head>";
  $output .= "<body>";
  $output .= "<img class='bizimg' src='{$bizimg}' alt='{$drdcard}'s bizimg''>";
  $output .= "<a href='{$vcard}'> download contact </a>";
  $output .= "<script src='js/jquery.js'></script>";
  $output .= "<?php";
  $output .= "if (stristr($_SERVER['HTTP_USER_AGENT'],'mobi')!==FALSE) {";
  $output .= "echo \"<script type='text/javascript'>";
  $output .= "$(document).ready(function(){";
  $output .= "window.location.href ='<?php echo {$vcard}; ?>';";
  $output .= "});";
  $output .= "</script>;\";";
  $output .= "}";
  $output .= "?>";
  $output .= "</body>";
  $output .= "</html>";
  $output .= "";
  echo $output;
 ?>

<?php
 if (isset($connection)) {
   mysqli_close($connection);
 }
?>
