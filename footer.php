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
