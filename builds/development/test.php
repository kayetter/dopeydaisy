<?php require_once("includes/session.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation.php"); ?>

<!DOCTYPE html>

<html>
  <head>
    <meta charset="utf-8">
    <title>server config</title>

    <pre>
    <?php
    $_SESSION["message"];
    print_r ($_SERVER);
    $drdcard = "kristin.yetter";
    $drd_redirect = "kristinyetter_redirect";
    $drdpin = "serf";
    $result = create_drdcard($drdcard, $drdpin, $drd_redirect);
    echo $result;
    print_r($errors);
    print_r($_SESSION["message"]);
     ?>

    </pre>

  </head>
  <body>

  </body>
</html>
