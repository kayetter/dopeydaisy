<footer class="footer">
  <div id="copyright"  role=contentinfo>
    <?php date_default_timezone_set('America/Denver'); ?>
      Copyright &copy; <?php echo date('Y'); ?>, Dame Ranch, LLC. <br> All Rights Reserved.
  </div>
  <div id="legal-claims">
      <p><a href="claim-of-confidentiality.html" target="_blank" class="footer-anchor" title="Claim of Confidentiality aka Privacy Policy">Claim of Confidentiality</a> <br>(aka Privacy Policy)</p>
      <p><a href="claim-of-respect.html" target="_blank" title="Claim of Respect aka Terms-of-Use" class="footer-anchor">Claim of Respect</a><br> (aka Terms of Use Policy)</p>
  </div>
  <div>
      Website divinely inspired by:
      <br><a href="https://dameranchdesigns.com" class="footer-anchor drd-a" target = '_blank'><span>dameranchdesigns.com</span></a><br>
      problems with website contact: <br> <a href="mailTo:admin@dameranchdesigns.com" target = '_blank' class="footer-anchor drd-a" >admin@dameranchdesigns.com</a>
  </div>
</footer>
<!-- script calls -->
<script src='../../scripts/lib-scripts.js'></script>
<script src='../../scripts/main.js'></script>
<script>

</script>


</body>
</html>
<?php
 if (isset($connection)) {
   mysqli_close($connection);
 }
  // 5. Close database connection
?>
