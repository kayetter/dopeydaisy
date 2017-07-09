<link rel='icon' href='images/logos/Bee_SideRight.ico' type='image/x-icon'>
<link rel='stylesheet' href='css/lib-styles.css'>
<link rel='stylesheet' href='css/style.css'>
</head>

<body>
<?php
  if(!password_verify($drdpin, $hashed_pin)){
    header("Location: https://dopeydaisy.com/no_pin/");
      exit;}
?>
