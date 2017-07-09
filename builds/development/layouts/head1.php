<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php
  $drdcard = ltrim((rtrim($_SERVER["SCRIPT_NAME"], ".php")), "/");
  $drdpin = $_SERVER["QUERY_STRING"];
  $hashed_pin = find_another_field_by_field($drdcard, "bizcard", "drdcard", "hashed_pin"); ?>

<!DOCTYPE html>
<html lang='en' prefix='og: http://ogp.me/ns#'>

<head>
  <meta charset='UTF-8'>
  <meta name='viewport' content='user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width'>
  <meta name='apple-mobile-web-app-capable' content='yes'>
  <meta http-equiv='X-UA-Compatible' content='ie=edge'>
