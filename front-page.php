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
      $tax = [
        'tax_query' => [
          [
            'taxonomy' => 'category',
            'field' => 'term_id',
            'terms' => [$sec_id],
            'include_children' => true,
          ],
        ],
      ];
      $main = new WP_Query($tax + ['posts_per_page'=>1,'ignore_sticky_posts'=>true]);
      $center_list = new WP_Query($tax + ['posts_per_page'=>2,'offset'=>1,'ignore_sticky_posts'=>true]);
      $right = new WP_Query($tax + ['posts_per_page'=>4,'offset'=>4,'ignore_sticky_posts'=>true]);
      $lower = new WP_Query($tax + ['posts_per_page'=>3,'offset'=>8,'ignore_sticky_posts'=>true]);
  ?>
  <div class="section-band">
    <div class="section-band__inner">
      <a class="section-band__link" href="<?php echo esc_url(get_category_link($sec_id)); ?>">
        <?php echo esc_html(strtoupper($sec_name)); ?>
        <svg class="section-band__arrow" aria-hidden="true" viewBox="0 0 14 14" width="1em" height="1em">
          <path d="M3 0 L12 7 L3 14" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </a>
    </div>
  </div>
  <section class="also">
    <div class="also-parent">
      <div class="div2">
        <?php if ($main->have_posts()) : $main->the_post(); ?>
          <article class="also-single">
            <a class="also-single__media" href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-lg'); } ?>
            </a>
            <div class="also-single__text">
              <h3 class="also-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="also-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
              <div class="also-meta">
                <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
              </div>
            </div>
          </article>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
      <div class="div1">
        <?php if ($center_list->have_posts()) : ?>
          <?php while ($center_list->have_posts()) : $center_list->the_post(); ?>
            <article class="also-tile">
              <a class="thumb" href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
              </a>
              <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
              <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
              <div class="meta">
                <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
              </div>
            </article>
          <?php endwhile; ?>
          <?php wp_reset_postdata(); ?>
        <?php endif; ?>
      </div>
      <div class="div4">
        <?php if ($right->have_posts()) : $right->the_post(); ?>
          <article class="also-sidecard">
            <a class="thumb" href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('card-sm'); } ?>
            </a>
            <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
            <div class="meta">
              <?php
                $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
                $cats = get_the_category();
                $cat = $cats ? $cats[0]->name : '';
                echo esc_html($ago).' ago';
                if ($cat) echo ' • '.esc_html($cat);
              ?>
            </div>
          </article>
        <?php endif; ?>
        <?php if ($right->have_posts()) : ?>
          <div class="also-rightlist">
            <?php while ($right->have_posts()) : $right->the_post(); ?>
              <article class="rightlist-item">
                <h5 class="rightlist-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                <p class="rightlist-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 20)); ?></p>
                <div class="rightlist-meta">
                  <?php
                    $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
                    $cats = get_the_category();
                    $cat = $cats ? $cats[0]->name : '';
                    echo esc_html($ago).' ago';
                    if ($cat) echo ' • '.esc_html($cat);
                  ?>
                </div>
              </article>
            <?php endwhile; wp_reset_postdata(); ?>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </section>
  <?php endforeach; ?>
</main>
<?php get_footer(); ?>
