<?php
$main = $args['main'] ?? null;
$center_list = $args['center_list'] ?? null;
$right = $args['right'] ?? null;
?>
<div class="also-parent">
  <div class="div2">
    <?php if ($main && $main->have_posts()) : $main->the_post(); ?>
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
    <?php if ($center_list && $center_list->have_posts()) : ?>
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
    <?php if ($right && $right->have_posts()) : $right->the_post(); ?>
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
    <?php if ($right && $right->have_posts()) : ?>
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
