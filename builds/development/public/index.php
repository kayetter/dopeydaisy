<?php require_once("../includes/session.php"); ?>
<?php require_once("../includes/db_connection.php"); ?>
<?php require_once("../includes/functions.php"); ?>
<?php require_once("../includes/validation.php"); ?>

<!DOCTYPE html>
<html lang="en" prefix="og: http://ogp.me/ns#">

<head>
    <meta charset="UTF-8">
    <!-- this viewport tag solves some of the problems associated with orientation change-->
    <meta name = "viewport" content = "user-scalable=no, initial-scale=1.0, maximum-scale=1.0, width=device-width"/>
    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DameRanchDesigns</title>


    <!--==Facebook OG content -->
    <meta property="fb:app_id" content="1696100190650596" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="https://dameranchdesigns.com/" />
    <meta property="og:title" content="Dame Ranch Designs" />
    <meta property="og:description" content="Divinely inspired logo graphics and website design. A whole new way of being ... on the internet." />
    <meta property="og:image"  content="https://dameranchdesigns.com/images/logos/DRDSunLncropped.png" />

    <!--==pinterest verification=====-->
    <meta name="p:domain_verify" content="da9a089c66574d3cb6e76cadf83b66c0"/>
    <!--==twitter OG content============-->
    <meta name="twitter:site" content="@dameranchdesign" />
    <meta name="twitter:creator" content="@dameranchdesign" />
    <meta property="twitter:image"  content="https://dameranchdesigns.com/images/logos/DRD_sunday_ln.png" />
    <meta name="twitter:title" content="Dame Ranch Designs"/>
    <meta name="twitter:description" content="Divinely inspired logo graphics and website design. A whole new way of being ... on the internet"/>
    <meta name="twitter:domain" content="dameranchdesigns.com"/>
    <meta name="twitter:card" content="summary" />

    <!-- Favicon links -->
    <link rel="icon" href="images/Bee_SideRight.ico" type="image/x-icon">

    <link rel='stylesheet' href='../css/lib-styles.css'>
    <link rel='stylesheet' href='../css/style.css'>

</head>

  <body>
    <pre class="errors">

    </pre>

  <div class="form-div">
      <img style = "width: 100%; max-width: 600px; margin: auto;" src="images/drdbizcard.png" alt="">

      <!-- bizcard entry form -->
    <form method="post" action="test_upload.php?user_id=2000004" name="file-upload" enctype="multipart/form-data" id="create-bizcard-form" class="form">
      <!--upload vcard file-->
      <label for="vcard-file">Upload a vcard (.vcf) file</label>
      <input type="file" name="vcard" id='vcard-file' required><br />

      <!-- upload bizimg file -->
      <label for="bizimg-file">Upload an image of your business card</label>
      <input type="file" name="bizimg" id='bizimg-file' required><br />

      <!-- create unique url -->
      <label for="drdcard">Create your url (no special characters allowed except ".")</label>
      <input type="text" name="drdcard" id="drdcard" pattern="[a-zA-Z0-9.]+" required placeholder= "john.a.smith" title="no special characters or spaces. periods are allowed" oninput="create_bizcard_link();"><br />

      <!-- create unique pin -->
      <label for="drdpin">Create 5 character pin</label>
      <input type="text" name="drdpin" id="drdpin" pattern="[a-z0-9]{5}" placeholder= "<?php echo substr(uuidSecure(),0,5);?>" required title="A-z, a-z, 0-9" oninput="create_bizcard_link();" max="5" min="5"><br>

      <!-- og:title-->
      <label for="og-title">Input title (<100 chars)</label>
      <input type="text" name="og[title]" id='og-title' required maxlength="100"><br />

      <!-- og:description -->
      <label for="og-description">Input description (<200 chars) <label>
      <input type="text" name="og[desc]" id='og-description' maxlength="200" title="maximum length is 200 characters"><br />
    </div>

      <div>
        <h2>This is your bizcard link</h2>
        <h3 id="drdcard-text"></h3>
      </div>


      <input type="submit" name="submit" value="Submit">

    </form>

  <script src="../js/jquery.js"></script>
  <script type="text/javascript">
  function create_bizcard_link(){
     $('#drdcard-text').text("https://drd.cards/"+$("#drdcard").val()+"?"+$("#drdpin").val());
    }
  $(document).ready(function(){

});

  </script>
  </body>
</body>

</html>
