<?php get_header(); ?>
<main class="site-main" role="main">
  <h1 class="section-title" style="text-align:center;color:var(--accent);font-weight:700;letter-spacing:.5px"><?php single_cat_title(); ?></h1>
  <?php
  $cat_id = get_queried_object_id();
  $tax = [
    'tax_query' => [
      [
        'taxonomy' => 'category',
        'field' => 'term_id',
        'terms' => [$cat_id],
        'include_children' => true,
      ],
    ],
  ];
  $main = new WP_Query($tax + ['posts_per_page'=>1,'ignore_sticky_posts'=>true]);
  $center_list = new WP_Query($tax + ['posts_per_page'=>4,'offset'=>1,'ignore_sticky_posts'=>true]);
  $right = new WP_Query($tax + ['posts_per_page'=>4,'offset'=>5,'ignore_sticky_posts'=>true]);
  $lower = new WP_Query($tax + ['posts_per_page'=>4,'offset'=>9,'ignore_sticky_posts'=>true]);
  ?>
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
    <div class="also-lower">
      <?php if ($lower->have_posts()) : ?>
        <?php while ($lower->have_posts()) : $lower->the_post(); ?>
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
  </section>
</main>
<?php get_footer(); ?>