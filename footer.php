<?php
?>
<footer class="site-footer" role="contentinfo">
  <div class="site-footer__inner">
    <div class="footer-brand">
      <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <?php if (function_exists('the_custom_logo') && has_custom_logo()) { the_custom_logo(); } else { ?>
          <span class="brand-box"><?php bloginfo('name'); ?></span>
        <?php } ?>
      </a>
      <p class="footer-copy">&copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>.</p>
    </div>
    <div class="footer-cats">
      <h4>Categories</h4>
      <ul>
        <?php foreach (get_categories(['parent'=>0,'hide_empty'=>false,'orderby'=>'name','order'=>'ASC']) as $c): ?>
          <li><a href="<?php echo esc_url(get_category_link($c)); ?>"><?php echo esc_html($c->name); ?></a></li>
        <?php endforeach; ?>
      </ul>
    </div>
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
