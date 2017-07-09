<?php require_once("includes/session.php"); ?>
<?php require_once("includes/db_connection.php"); ?>
<?php require_once("includes/functions.php"); ?>
<?php require_once("includes/validation.php"); ?>



<pre>
<?php
//add user

$user_unique_id = mt_rand();
$username = mysql_prep("debrakay");
$firstname = mysql_prep("Debra");
$lastname = mysql_prep("Jones");

$query = "insert into user (";
$query .= "username, firstname, lastname, user_unique_id";
$query .= ") values (";
$query .= "'{$username}', '{$firstname}', '{$lastname}', {$user_unique_id}";
$query .= ")";

$result = mysqli_query($connection, $query);
confirm_query_query($result, $query);
//return new user_id
$user_id = mysqli_insert_id($connection);

//add bizcard
$bizcard_unique_id = mt_rand();
$vcard = "BEGIN:VCARD
VERSION:3.0
FN:Your Name
N:Name;Your;;;
EMAIL;TYPE=INTERNET;TYPE=WORK:your@email.here
TEL;TYPE=CELL:
ADR;TYPE=HOME:;;I am here;;;;
ORG:Your organization
TITLE:Owner and Co-Creator
item1.URL:https\://yoursite.com
item1.X-ABLabel:_$!<HomePage>!$_
END:VCARD";
$vcard_prep = mysql_prep($vcard);
echo "vcard: ".$vcard . "\n";
echo "vcard_prep: " .$vcard_prep . "\n";

echo htmlspecialchars_decode($vcard_prep) . "\n";
echo htmlentities($vcard_prep) . "\n";


$img = mysql_prep("images\debra_jones.png");
$query = "insert into bizcard (";
$query .= "vcard, img, bizcard_unique_id";
$query .= ") values (";
$query .= "'{$vcard}', '{$img}', {$bizcard_unique_id}";
$query .= ")";


$result = mysqli_query($connection, $query);
confirm_query_query($result, $query);
//return new bizcard_id
$bizcard_id = mysqli_insert_id($connection);

//create association
$query = "insert into user_bizcard (";
$query .= "user_id, bizcard_id";
$query .= ") values (";
$query .= "{$user_id}, {$bizcard_id}";
$query .= ")";
$result = mysqli_query($connection, $query);
confirm_query_query($result, $query);


 ?>


</pre>
