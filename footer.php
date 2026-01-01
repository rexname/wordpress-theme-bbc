<?php
?>
<footer class="site-footer" role="contentinfo">
  <div class="site-footer__inner">
    <div class="footer-top">
      <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <?php if (function_exists('the_custom_logo') && has_custom_logo()) { the_custom_logo(); } else { ?>
          <span class="brand-box"><?php bloginfo('name'); ?></span>
        <?php } ?>
      </a>
    </div>
    <div class="footer-nav">
      <?php theme_primary_dynamic_nav(); ?>
    </div>
    <div class="footer-row">
      <div class="footer-item">
        <h4 class="footer-heading">Follow <?php bloginfo('name'); ?> on:</h4>
        <ul class="footer-social">
          <li><a href="#">X</a></li>
          <li><a href="#">Facebook</a></li>
          <li><a href="#">Instagram</a></li>
          <li><a href="#">TikTok</a></li>
          <li><a href="#">LinkedIn</a></li>
          <li><a href="#">YouTube</a></li>
        </ul>
      </div>
    </div>
    <div class="footer-legal">
      <ul class="footer-links">
        <li><a href="#">Terms of Use</a></li>
        <li><a href="#">Subscription Terms</a></li>
        <li><a href="#">About Us</a></li>
        <li><a href="#">Privacy Policy</a></li>
        <li><a href="#">Cookies</a></li>
        <li><a href="#">Accessibility Help</a></li>
        <li><a href="#">Contact Us</a></li>
        <li><a href="#">Advertise with us</a></li>
        <li><a href="#">Do not share or sell my info</a></li>
        <li><a href="#">Help & FAQs</a></li>
        <li><a href="#">Content Index</a></li>
      </ul>
      <p class="footer-copy">Copyright &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved. This site is not responsible for the content of external sites. <a href="#">Read about our approach to external linking.</a></p>
    </div>
  </div>
</footer>
<script>
  (function(){
    var nav = document.getElementById('site-navbar');
    var brandbar = document.querySelector('.site-brandbar');
    if(!nav) return;
    var last = window.scrollY || 0;
    var ticking = false;
    var navH = nav.offsetHeight || 0;
    document.body.style.setProperty('--navbar-h', navH + 'px');
    window.addEventListener('resize', function(){
      var h = nav.offsetHeight || 0;
      document.body.style.setProperty('--navbar-h', h + 'px');
    });
    function showNav(){ if(nav.classList.contains('hide')){ nav.classList.remove('hide'); } }
    function hideNav(){ if(!nav.classList.contains('hide')){ nav.classList.add('hide'); } }
    function onScroll(){
      var y = window.scrollY || 0;
      var brandH = parseFloat(getComputedStyle(document.body).getPropertyValue('--brandbar-h'))||60;
      if (y > 80) {
        document.body.classList.add('brandbar-shrink');
      } else {
        document.body.classList.remove('brandbar-shrink');
      }
      if (brandbar) {
        if (y > 4) brandbar.classList.add('scrolled'); else brandbar.classList.remove('scrolled');
      }
      if (y > last && y > brandH + 1) { hideNav(); }
      else if (y < last) { showNav(); }
      last = y;
      ticking = false;
    }
    window.addEventListener('scroll', function(){
      if(!ticking){
        window.requestAnimationFrame(onScroll);
        ticking = true;
      }
    });
  })();
</script>
<?php wp_footer(); ?>
</body>
</html>
