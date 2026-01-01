<?php get_header(); ?>
<main class="site-main" role="main">
  <?php if (have_posts()): while (have_posts()): the_post(); ?>
    <article id="post-<?php the_ID(); ?>" <?php post_class('paper'); ?>>
      <header class="paper-head">
        <h1 class="paper-title"><?php the_title(); ?></h1>
        <div class="paper-meta">
    <span>
        <?php
        $ago = human_time_diff(get_the_time('U'), current_time('timestamp'));
        echo esc_html($ago).' ago';
        ?>
    </span>
    <div class="paper-by">
        By <?php the_author(); ?>
    </div>
</div>
<div class="paper-actions">
    <a href="#"><i class="fa-solid fa-share-nodes"></i> Share</a>
    <a href="#"><i class="fa-regular fa-bookmark"></i> Save</a>
</div>
      </header>

      <?php if (has_post_thumbnail()) : ?>
        <figure class="paper-thumb"><?php the_post_thumbnail('hero-lg'); ?></figure>
      <?php endif; ?>

      <div class="paper-body entry-content">
        <?php the_content(); ?>
      </div>
      <?php
        $more_q = new WP_Query([
          'cat' => $rel_cat,
          'post__not_in' => [get_the_ID()],
          'posts_per_page' => 4,
          'ignore_sticky_posts' => true,
        ]);
      ?>
      <?php if ($more_q->have_posts()) : ?>
      <section class="paper-under">
        <h2 class="sub-title">MORE FROM THIS CATEGORY</h2>
        <div class="stream-grid">
          <?php while ($more_q->have_posts()) : $more_q->the_post(); ?>
            <article class="stream-card">
              <a class="stream-thumb" href="<?php the_permalink(); ?>">
                <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
              </a>
              <h3 class="stream-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            </article>
          <?php endwhile; wp_reset_postdata(); ?>
        </div>
      </section>
      <?php endif; ?>
    </article>
  <?php endwhile; endif; ?>

  <?php
    $rel_cat = $cats && isset($cats[0]) ? (int)$cats[0]->term_id : 0;
    $related = new WP_Query([
      'cat' => $rel_cat,
      'post__not_in' => [get_the_ID()],
      'posts_per_page' => 6,
      'ignore_sticky_posts' => true,
    ]);
  ?>
  <?php if ($related->have_posts()) : ?>
  <section class="paper-related">
    <h2 class="sub-title">YOU MAY ALSO LIKE</h2>
    <div class="stream-grid">
      <?php while ($related->have_posts()) : $related->the_post(); ?>
        <article class="stream-card">
          <a class="stream-thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
          </a>
          <h3 class="stream-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
        </article>
      <?php endwhile; wp_reset_postdata(); ?>
    </div>
  </section>
  <?php endif; ?>
</main>
<?php get_footer(); ?>
