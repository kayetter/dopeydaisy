<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once('../includes/OpenGraph.php'); ?>



<html>
    	<head>
        		<title>Php code compress the image</title>
    	</head>
    	<body>
<pre>
<?php $tags = get_meta_tags("http://drd.cards/kristin.yetter");
print_r($tags);

$graph = OpenGraph::fetch('http://drd.cards/kristin.yetter');
var_dump($graph->keys());
var_dump($graph->schema);

foreach ($graph as $key => $value) {
	echo "$key => $value<br>";
}

 ?>



</pre>




	</body>
</html>
