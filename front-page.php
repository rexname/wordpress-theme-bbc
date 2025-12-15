<?php get_header(); ?>
<main class="site-main" role="main">
  <h1 class="section-title" style="text-align:center;color:var(--accent);font-weight:700;letter-spacing:.5px">NEWS</h1>
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
  ?>
  <section class="home-hero">
    <div class="hero-left">
      <?php if ($main_q->have_posts()) : $main_q->the_post(); ?>
        <article class="hero-lead">
          <h2 class="hero-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
          <p class="hero-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 28)); ?></p>
          <div class="hero-meta">
            <?php
              $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
              $cats = get_the_category();
              $cat = $cats ? $cats[0]->name : '';
              echo esc_html($ago).' ago';
              if ($cat) echo ' • '.esc_html($cat);
            ?>
          </div>
        </article>
      <?php wp_reset_postdata(); endif; ?>
    </div>

    <div class="hero-center">
      <?php if ($main_q) : ?>
        <div class="hero-image">
          <?php
            // Ambil ulang post pertama untuk gambar (jika reset di atas)
            $first = new WP_Query(['posts_per_page'=>1,'ignore_sticky_posts'=>true]);
            if ($first->have_posts()) { $first->the_post(); if (has_post_thumbnail()) the_post_thumbnail('hero-lg'); }
            wp_reset_postdata();
          ?>
        </div>
      <?php endif; ?>
    </div>

    <aside class="hero-side">
      <?php if ($side_q->have_posts()) : while ($side_q->have_posts()) : $side_q->the_post(); ?>
        <article class="side-item">
          <a class="side-thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
          </a>
          <div class="side-text">
            <h3 class="side-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            <p class="side-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 18)); ?></p>
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
        </article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </aside>
  </section>

  <?php
  $teasers_q = new WP_Query([
    'posts_per_page' => 6,
    'offset' => 3,
    'ignore_sticky_posts' => true,
  ]);
  ?>
  <section class="home-teasers">
    <div class="teasers-row">
      <?php if ($teasers_q->have_posts()) : while ($teasers_q->have_posts()) : $teasers_q->the_post(); ?>
        <article class="teaser">
          <a class="teaser-thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('card-sm'); } ?>
          </a>
          <h3 class="teaser-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <p class="teaser-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 16)); ?></p>
          <div class="teaser-meta">
            <?php
              $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
              $cats = get_the_category();
              $cat = $cats ? $cats[0]->name : '';
              echo esc_html($ago).' ago';
              if ($cat) echo ' • '.esc_html($cat);
            ?>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
  </section>

  <?php
  $links_q = new WP_Query([
    'posts_per_page' => 6,
    'offset' => 9,
    'ignore_sticky_posts' => true,
  ]);
  ?>
  <section class="home-links">
    <div class="links-row">
      <?php if ($links_q->have_posts()) : while ($links_q->have_posts()) : $links_q->the_post(); ?>
        <article class="link-item"><h3 class="link-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3></article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
  </section>

  <?php
  $sections_ids = [];
  $tops = get_categories(['parent'=>0,'hide_empty'=>true,'orderby'=>'name','order'=>'ASC']);
  foreach ($tops as $t) { $sections_ids[] = (int) $t->term_id; }
  foreach ($sections_ids as $sec_id):
    $sec_cat = get_category($sec_id);
    $sec_name = ($sec_cat && !is_wp_error($sec_cat)) ? $sec_cat->name : 'NEWS';
    $main = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>1,'ignore_sticky_posts'=>true]);
    $media = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>2,'offset'=>1,'ignore_sticky_posts'=>true]);
    $right = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>3,'offset'=>3,'ignore_sticky_posts'=>true]);
    $lower = new WP_Query(['cat'=>$sec_id,'posts_per_page'=>5,'offset'=>6,'ignore_sticky_posts'=>true]);
  ?>
  <section class="also">
    <h2 class="sub-title">ALSO IN <?php echo esc_html($sec_name); ?></h2>
    <div class="also-grid">
      <div class="also-left">
        <?php if ($main->have_posts()) : $main->the_post(); ?>
          <div class="also-lead">
            <div class="also-lead-media">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-lg'); } ?>
            </div>
            <div class="also-lead-text">
              <h3 class="also-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
              <p class="also-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 30)); ?></p>
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
      <aside class="also-right">
        <?php if ($right->have_posts()) : while ($right->have_posts()) : $right->the_post(); ?>
          <article class="also-item">
            <h4 class="also-item-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
            <p class="also-item-excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 24)); ?></p>
            <div class="also-item-meta">
              <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
            </div>
          </article>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </aside>
    </div>

    <div class="also-lower">
      <?php if ($lower->have_posts()) : while ($lower->have_posts()) : $lower->the_post(); ?>
        <article class="also-card v">
          <a class="thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('card-sm'); } ?>
          </a>
          <h4 class="title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
          <p class="excerpt"><?php echo esc_html(wp_trim_words(get_the_excerpt(), 22)); ?></p>
          <div class="meta">
            <?php $ago = human_time_diff(get_the_time('U'), current_time('timestamp')); echo esc_html($ago).' ago'; ?>
          </div>
        </article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
    <div class="also-more"><a href="<?php echo esc_url(get_category_link($sec_id)); ?>">More</a></div>
  </section>
  <?php endforeach; ?>
</main>
<?php get_footer(); ?>
