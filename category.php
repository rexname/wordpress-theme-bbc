<?php get_header(); ?>
<main class="site-main" role="main">
  <h1 class="section-title" style="text-align:center;color:var(--accent);font-weight:700;letter-spacing:.5px"><?php single_cat_title(); ?></h1>
  <?php
  $cat_id = get_queried_object_id();
  $main_q = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 1,
    'ignore_sticky_posts' => true,
  ]);
  $side_q = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 2,
    'offset' => 1,
    'ignore_sticky_posts' => true,
  ]);
  ?>
  <section class="home-hero">
    <?php if ($main_q->have_posts()) : $main_q->the_post(); ?>
      <div class="hero-main">
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
      </div>
      <div class="hero-image">
        <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-lg'); } ?>
      </div>
    <?php wp_reset_postdata(); endif; ?>

    <aside class="hero-side">
      <?php if ($side_q->have_posts()) : while ($side_q->have_posts()) : $side_q->the_post(); ?>
        <article class="side-item">
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
        </article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </aside>
  </section>

  <?php
  $cards_q = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 6,
    'offset' => 3,
    'ignore_sticky_posts' => true,
  ]);
  ?>
  <?php if ($cards_q->have_posts()) : ?>
  <section>
    <div class="cards-grid">
      <?php while ($cards_q->have_posts()) : $cards_q->the_post(); ?>
        <article class="card">
          <a class="card-thumb" href="<?php the_permalink(); ?>">
            <?php if (has_post_thumbnail()) { the_post_thumbnail('card-sm'); } ?>
          </a>
          <h3 class="card-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          <div class="card-meta">
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
  </section>
  <?php endif; ?>

  <?php
  $also_main = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 1,
    'offset' => 9,
    'ignore_sticky_posts' => true,
  ]);
  $also_media = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 2,
    'offset' => 10,
    'ignore_sticky_posts' => true,
  ]);
  $also_center_list = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 3,
    'offset' => 12,
    'ignore_sticky_posts' => true,
  ]);
  $also_right = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 3,
    'offset' => 15,
    'ignore_sticky_posts' => true,
  ]);
  $also_cards = new WP_Query([
    'cat' => $cat_id,
    'posts_per_page' => 5,
    'offset' => 18,
    'ignore_sticky_posts' => true,
  ]);
  ?>
  <section class="also">
    <h2 class="sub-title">ALSO IN <?php echo esc_html(single_cat_title('', false)); ?></h2>
    <div class="also-grid">
      <div class="also-left">
        <?php if ($also_main->have_posts()) : $also_main->the_post(); ?>
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
        <?php if ($also_media->have_posts()) : while ($also_media->have_posts()) : $also_media->the_post(); ?>
          <div class="also-media">
            <a href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
            </a>
          </div>
        <?php endwhile; wp_reset_postdata(); endif; ?>
      </div>
      <aside class="also-right">
        <?php if ($also_right->have_posts()) : while ($also_right->have_posts()) : $also_right->the_post(); ?>
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
      <?php if ($also_cards->have_posts()) : while ($also_cards->have_posts()) : $also_cards->the_post(); ?>
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
  </section>
  
  <section class="category-stream">
    <div class="stream-grid" id="stream-grid">
      <?php
        $stream = new WP_Query([
          'cat' => $cat_id,
          'posts_per_page' => 10,
          'offset' => 23,
          'ignore_sticky_posts' => true,
        ]);
        if ($stream->have_posts()) : while ($stream->have_posts()) : $stream->the_post(); ?>
          <article class="stream-card">
            <a class="stream-thumb" href="<?php the_permalink(); ?>">
              <?php if (has_post_thumbnail()) { the_post_thumbnail('hero-side'); } ?>
            </a>
            <h3 class="stream-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
          </article>
      <?php endwhile; wp_reset_postdata(); endif; ?>
    </div>
  </section>

  <script>
    (function(){
      var catId = <?php echo (int) $cat_id; ?>;
      var grid = document.getElementById('stream-grid');
      var nextOffset = 33; // 23 + 10 loaded above
      var loading = false; var done = false;
      function nearBottom(){ return (window.innerHeight + window.scrollY) >= (document.body.offsetHeight - 300); }
      function imgFromEmbedded(p){ try{ var m=p._embedded['wp:featuredmedia'][0]; var s=m.media_details.sizes; return (s.hero_side||s.medium||s.large||s.full||{}).source_url || m.source_url; }catch(e){ return ''; } }
      function cardHTML(p){ var u = imgFromEmbedded(p); return '<article class="stream-card">'+
        '<a class="stream-thumb" href="'+p.link+'">'+(u?'<img src="'+u+'" alt="">':'')+'</a>'+
        '<h3 class="stream-title"><a href="'+p.link+'">'+p.title.rendered+'</a></h3>'+
      '</article>'; }
      async function loadMore(){ if(loading||done) return; loading=true; try{
        var url = (window.location.origin + '/wp-json/wp/v2/posts?categories='+catId+'&per_page=12&offset='+nextOffset+'&_embed=1');
        var res = await fetch(url); var posts = await res.json();
        if(!Array.isArray(posts) || posts.length===0){ done=true; return; }
        var frag = document.createDocumentFragment();
        posts.forEach(function(p){ var div=document.createElement('div'); div.innerHTML = cardHTML(p); frag.appendChild(div.firstChild); });
        grid.appendChild(frag); nextOffset += posts.length;
      } finally { loading=false; } }
      function onScroll(){ if(nearBottom()) loadMore(); }
      window.addEventListener('scroll', onScroll);
    })();
  </script>
</main>
<?php get_footer(); ?>
