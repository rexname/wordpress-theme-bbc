<?php get_header(); ?>
<main class="site-main" role="main">
  <?php
  $main_q = new WP_Query([
    'posts_per_page' => 1,
    'ignore_sticky_posts' => true,
  ]);
  $side_q = new WP_Query([
    'posts_per_page' => 2,
    'offset' => 1,
    'ignore_sticky_posts' => true,
  ]);
  $right_q = new WP_Query([
    'posts_per_page' => 4,
    'offset' => 3,
    'ignore_sticky_posts' => true,
  ]);
  ?>
  <section class="home-hero">
    <div class="hero-composite">
      <div class="hero-left">
      <?php if ($side_q->have_posts()) : while ($side_q->have_posts()) : $side_q->the_post(); ?>
        <div class="side-item">
          <a class="side-thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
          </a>
          <div class="side-text">
            <h3 class="side-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="side-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
            <div class="side-meta">
              <?php
                $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
                $cats = get_the_category();
                $cat = $cats ? $cats[0]->name : '';
                echo esc_html($ago).' ago';
                if ($cat) echo ' • '.esc_html($cat);
              ?>
            </div>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>

      <div class="hero-center">
        <?php if ($main_q->have_posts()) : $main_q->the_post(); ?>
          <div class="hero-image"><?php if (has_post_thumbnail()) { the_post_thumbnail('hero-lg'); } ?></div>
          <div class="hero-lead hero-center-text">
            <h2 class="hero-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
            <p class="hero-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 32)); ?></p>
            <div class="hero-meta">
              <?php
                $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
                $cats = get_the_category();
                $cat = $cats ? $cats[0]->name : '';
                echo esc_html($ago).' ago';
                if ($cat) echo ' • '.esc_html($cat);
              ?>
            </div>
          </div>
        <?php wp_reset_postdata(); endif; ?>
      </div>
    </div>
    <div class="hero-right">
      <?php if ($right_q->have_posts()) : while ($right_q->have_posts()) : $right_q->the_post(); ?>
        <div class="right-item">
          <h3 class="right-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="right-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
          <div class="right-meta">
            <?php
              $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
              $cats = get_the_category();
              $cat = $cats ? $cats[0]->name : '';
              echo esc_html($ago).' ago';
              if ($cat) echo ' • '.esc_html($cat);
            ?>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
  </section>

  <?php
    $sections_ids = bbc_get_home_section_category_ids();
    foreach ($sections_ids as $sec_id):
      $sec_cat = get_category($sec_id);
      $sec_name = ($sec_cat && !is_wp_error($sec_cat)) ? $sec_cat->name : '';
      $main = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>1,'ignore_sticky_posts'=>true]);
      $media = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>2,'offset'=>1,'ignore_sticky_posts'=>true]);
      $right = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>3,'offset'=>3,'ignore_sticky_posts'=>true]);
      $lower = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>5,'offset'=>6,'ignore_sticky_posts'=>true]);
  ?>
  <div class="section-band"><div class="section-band__inner"><?php echo esc_html(strtoupper($sec_name)); ?></div></div>
  <section class="also">
    <div class="also-grid">
      <div class="also-left">
        <?php if ($main->have_posts()) : $main->the_post(); ?>
          <div class="also-lead">
            <div class="also-lead-media">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-lg'); } ?>
            </div>
            <div class="also-lead-text">
              <h3 class="also-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="also-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
              <div class="also-meta">
                <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
              </div>
            </div>
          </div>
        <?php wp_reset_postdata(); endif; ?>
      </div>
      <div class="also-center">
        <?php if ($media->have_posts()) : while ($media->have_posts()) : $media->the_post(); ?>
          <div class="also-media">
            <a href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
            </a>
          </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
      <div class="also-right">
        <?php if ($right->have_posts()) : while ($right->have_posts()) : $right->the_post(); ?>
          <div class="right-item">
            <h4 class="right-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <p class="right-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
            <div class="right-meta">
              <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
            </div>
          </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
    </div>
    <div class="also-lower">
      <?php if ($lower->have_posts()) : while ($lower->have_posts()) : $lower->the_post(); ?>
        <div class="also-card v">
          <a class="thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('card-sm'); } ?>
          </a>
          <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
          <div class="meta">
            <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
          </div>
        </div>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
  </section>
  <?php endforeach; ?>
</main>
<?php get_footer(); ?>
