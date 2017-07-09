<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>
<?php


  //get bizcard record
  $bizcard_record = find_record_by_field($drdcard, "bizcard", "drdcard");
    $og_url = "https://{$domain}/{$uri}";
    $user_bizcard_id = $bizcard_record["user_bizcard_id"];
    $bizcard_content = get_bizcard_items($user_bizcard_id);
    $bizimg = $bizcard_content["bizimg"];
    $vcard = $bizcard_content["vcard"];
    $og_title = "put title here";
    $og_desc = "";

function build_bizcard_output(
  $drdcard,
  $drdpin,
  $vcard,
  $bizimg,
  $og_title,
  $og_desc
    ){
  $output = "<?php require_once(\"../includes/db_connection.php\"); ?>";
  $output .= "<?php require_once(\"../includes/functions.php\"); ?>";
  $output .= "<?php \$drdcard= \$_SERVER[\"SCRIPT_NAME\"];";
  $output .= "\$drdpin = \$_SERVER[/"QUERY_STRING/"];";
  $output .= "\$hashed_pin = find_another_field_by_field(\$drdcard, \$bizcard, \"drdcard\", \"hashed_pin\");";
  $output .= "";
  $output .= "";
  $output .= "";
  $output .= "?>";
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
  $output .= "<?php if(!password_verify(\$drdpin, \$hashed_pin)){";
  $output .= "header("Location: https:\/\/dopeydaisy.com\/no_pin\/\");
  exit;";
  $output .= "};?>";
  $output .= "<img class='bizimg' src='{$bizimg}' alt='{$drdcard}'s bizimg''>";
  $output .= "<a href='{$vcard}'> download contact </a>";
  $output .= "<script src='js/jquery.js'></script>";
  $output .= "<?php";
  $output .= "if (stristr(\$_SERVER['HTTP_USER_AGENT'],'mobi')!==FALSE) {";
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
  return $output;
  }



 ?>

<?php
 if (isset($connection)) {
   mysqli_close($connection);
 }
?>
