<?php
?><!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header" role="banner">
  <div class="site-brandbar" role="banner">
    <div class="site-header__inner">
      <a class="site-brand" href="<?php echo esc_url(home_url('/')); ?>">
        <?php if (function_exists('the_custom_logo') && has_custom_logo()) { the_custom_logo(); } else { ?>
          <span class="brand-box"><?php bloginfo('name'); ?></span>
        <?php } ?>
      </a>
    </div>
  </div>

  <div class="site-navbar" id="site-navbar" role="navigation" aria-label="Site navigation">
    <div class="site-header__inner">
      <section class="site-mainnav">
        <nav class="primary-nav" aria-label="Primary">
        <?php
          if (has_nav_menu('primary')) {
              wp_nav_menu([
                  'theme_location' => 'primary',
                  'container' => false,
                  'menu_class' => 'primary-menu',
                  'fallback_cb' => 'theme_primary_dynamic_nav',
              ]);
          } else {
              theme_primary_dynamic_nav([]);
          }
        ?>
        </nav>
      </section>
    </div>
  </div>
</header>
