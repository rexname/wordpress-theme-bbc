<?php
?>
<footer class="site-footer" role="contentinfo">
  <div class="site-footer__inner">
    <p>&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>. All rights reserved.</p>
    <p><a href="<?php echo esc_url(home_url('/')); ?>">Home</a> · <a href="<?php echo esc_url(get_category_link(get_option('default_category'))); ?>">News</a></p>
  </div>
</footer>
<script>
  (function(){
    var nav = document.getElementById('site-navbar');
    if(!nav) return;
    var last = window.scrollY || 0;
    var ticking = false;
    function onScroll(){
      var y = window.scrollY || 0;
      var goingUp = y < last;
      if (y > 120 && goingUp) {
        nav.classList.remove('hide');
      } else if (y > 120 && !goingUp) {
        nav.classList.add('hide');
      } else {
        nav.classList.remove('hide');
      }
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
