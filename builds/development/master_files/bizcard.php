<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>
<?php
if(isset($_GET)){
  $drdpin = mysql_prep(array_keys($_GET)[0]);
  $drdcard= $_SERVER["SCRIPT_NAME"];
  //get bizcard record
  $bizcard_record = find_record_by_field($drdcard, "bizcard", "drdcard");

  //verify pin
  $hashed_pin = $bizcard_record["hashed_pin"];
  if($pin_verify=password_verify($drdpin, $hashed_pin);)
  $user_bizcard_id = $bizcard_record["user_bizcard_id"];

  $bizcard_content = get_bizcard_items($user_bizcard_id);


} else {
  //not a GET request
  redirect_to("https://dopeydaisy.com/no_pin/");
}
 ?>

<!DOCTYPE html>

<html lang="en" prefix="og: http://ogp.me/ns#">
<head>
    <meta charset="UTF-8">
    <!-- this viewport tag solves some of the problems associated with orientation change-->
    <meta name="viewport" content="user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Kristin Yetter Dame Ranch Designs</title>

    <!-— facebook open graph tags -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://ruraljuror.com/" />
    <meta property="og:title" content="Rural Juror" />
    <meta property="og:description" content="The film, based on a Kevin Grisham novel (John Grisham’s brother), revolves around a Southern–born lawyer named Constance Justice." />
    <meta property="og:image" content="http://ruraljuror.com/heroimage.png" />

    <!-— twitter card tags additive with the og: tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:domain" value="ruraljuror.com" />
    <meta name="twitter:title" value="Rural Juror" />
    <meta name="twitter:description" value="The film, based on a Kevin Grisham novel (John Grisham’s brother), revolves around a Southern–born lawyer named Constance Justice." />
    <meta name="twitter:image" content="http://ruraljuror.com/heroimage.png" />
    <meta name="twitter:url" value="http://www.ruraljuror.com/" />
    <meta name="twitter:label1" value="Opens in Theaters" />
    <meta name="twitter:data1" value="December 1, 2015" />
    <meta name="twitter:label2" value="Or on demand" />
    <meta name="twitter:data2" value="at Hulu.com" />

</head>

  <body>

    <pre>
      <?php
      echo $username. "<br>";
      echo $hashed_user_pin. "<br>";
      echo $firstname. "<br>";
      echo $lastname. "<br>";
      print_r($exploded_username);
      print_r($_SERVER);

       ?>
    </pre>
    <!-- <img style="width: 100%; max-width: 600px; margin: auto;" src="images/drdbizcard.png" alt="">

  <script src="js/jquery.js"></script>
  <script type="text/javascript">
    $(document).ready(function(){
      window.location.href = 'vcards/KAYetter.vcf';
    });
  </script> -->




</body></html>
