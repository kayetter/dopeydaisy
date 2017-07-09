<?php
  header("Location: ../bizcards/kristin.yetter.php?2589");
  exit; ?>

<?php
function create_drdcard($drdcard, $drdpin, $drd_redirect){
  $file = "../drd.cards/{$drdcard}";
  $drd_content = "<?php header(\"Location: ../dopeydaisy/bizcards/{$drd_redirect}?{drdpin}\")";
  file_put_contents($file,$drd_content);
  }
 ?>
