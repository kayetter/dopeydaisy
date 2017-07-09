<?php require_once("../vendor/autoload.php");
\Tinify\setKey("_AjaKK2LhIi8t8NQvm9nqcDvEJZIOx_I");
 ?>
<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>


<?php require_once("../includes/validation.php"); ?>


<pre>

<?php
$_SESSION["message"] = "";
$files = array
(
    "vcard" =>array
        (
            'name'=> "KAYetter29.vcf",
            'type' => "text/x-vcard",
            'tmp_name' => "C:\wamp64\tmp\phpEC2D.tmp",
            'error' => "0",
            'size' => "352",
            'new_path' => '..\vcards\12341234.vcf'
        ),

    "bizimg" =>array
        (
            'name' => "kristin_yetter_bizcard29.png",
            'type' => "image/png",
            'tmp_name' => "C:\wamp64\tmp\phpEC2E.tmp",
            'error' => "0",
            'size' => "1056419",
            'new_path' => '..\bizimg\12341234.vcf'
        )
);

$drdcard = "kristin.yetter1";
$drdpin = "rock1";
$vcard_new_path = "../vcards/19568c7d-fa39-43bc-a4e8-ece7ec9a06c0.vcf";
$bizimg_new_path = "../bizimg/39ac0091-04a6-4562-a572-bda4a65ea89c.png";
$og_title = "Kristin Yetter, Owner and Divine Operator";
$og_desc = "Divinely inspire freedom to choose";
// $drdcard_content = build_bizcard_output(
//   $drdcard,
//   $drdpin,
//   $vcard_new_path,
//   $bizimg_new_path,
//   $og_title,
//   $og_desc
// );
// file_put_contents("../".$drdcard.".php", $drdcard_content);

$img = "C:/Users/kasch/Documents/2016_Web_development/MySites/dopeydaisy/extra/kristin_yetter/large3.JPG";
$toFile = "C:/Users/kasch/Documents/2016_Web_development/MySites/dopeydaisy/extra/kristin_yetter/optimize2.JPG";


$factory = new \ImageOptimizer\OptimizerFactory(array('ignore_errors' => false));
$optimizer = $factory->get();
$filepath = "C:\Users\kasch\Documents\2016_Web_development\MySites\dopeydaisy\extra\kristin_yetter\large3.JPG";
$optimizer->optimize($filepath);


if($result){
  echo "true";
} else {
  echo "false";
}

?>

</pre>

<?php
 if (isset($connection)) {
   mysqli_close($connection);
 }
  // 5. Close database connection
?>
