<?php
add_action('after_setup_theme', function(){
    register_nav_menus([
        'primary' => __('Primary Menu','bbc'),
        'secondary' => __('Secondary Menu','bbc'),
    ]);
    add_theme_support('title-tag');
    add_theme_support('custom-logo', [
        'height' => 60,
        'width' => 60,
        'flex-height' => true,
        'flex-width' => true,
        'unlink-homepage-logo' => false,
    ]);
});

add_action('wp_enqueue_scripts', function(){
    wp_enqueue_style('bbc-style', get_stylesheet_uri(), [], '0.1.0');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Tinos:ital,wght@0,400;0,700;1,400;1,700&display=swap', [], null);
    if (is_category()) {
        wp_enqueue_script('bbc-load-more', get_template_directory_uri() . '/js/load-more.js', ['jquery'], '0.1.0', true);
        wp_localize_script('bbc-load-more', 'bbc_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce'    => wp_create_nonce('bbc_load_more_nonce'),
        ]);
    }
});

add_action('after_setup_theme', function(){
    add_image_size('hero-lg', 900, 500, true);
    add_image_size('hero-side', 420, 240, true);
    add_image_size('card-sm', 180, 120, true);
});

function bbc_get_home_section_category_ids(){
    $raw = get_theme_mod('bbc_home_categories', []);
    if (is_array($raw)) {
        $ids = array_map('absint', $raw);
    } else {
        $csv = (string) $raw;
        $ids = $csv !== '' ? array_map('absint', preg_split('/\s*,\s*/', $csv, -1, PREG_SPLIT_NO_EMPTY)) : [];
    }
    $ids = array_values(array_unique(array_filter($ids, function($v){ return $v > 0; })));
    if (empty($ids)) {
        $tops = get_categories(['parent'=>0,'hide_empty'=>false,'orderby'=>'count','order'=>'DESC']);
        foreach ($tops as $t) { $ids[] = (int) $t->term_id; }
        $ids = array_slice($ids, 0, 2);
    }
    return $ids;
}

 

add_action('wp_ajax_bbc_load_more', 'bbc_load_more_callback');
add_action('wp_ajax_nopriv_bbc_load_more', 'bbc_load_more_callback');

function bbc_load_more_callback() {
    check_ajax_referer('bbc_load_more_nonce', 'nonce');

    $offset = isset($_POST['offset']) ? intval($_POST['offset']) : 0;
    $cat_id = isset($_POST['cat_id']) ? intval($_POST['cat_id']) : 0;

    $tax = [
        'tax_query' => [
            [
                'taxonomy' => 'category',
                'field'    => 'term_id',
                'terms'    => [$cat_id],
                'include_children' => true,
            ],
        ],
    ];

    $main = new WP_Query($tax + ['posts_per_page' => 1, 'offset' => $offset, 'ignore_sticky_posts' => true]);
    $center_list = new WP_Query($tax + ['posts_per_page' => 4, 'offset' => $offset + 1, 'ignore_sticky_posts' => true]);
    $right = new WP_Query($tax + ['posts_per_page' => 4, 'offset' => $offset + 5, 'ignore_sticky_posts' => true]);
    $lower = new WP_Query($tax + ['posts_per_page' => 4, 'offset' => $offset + 9, 'ignore_sticky_posts' => true]);

    ob_start();
    if ($main->have_posts()) {
        get_template_part('template-parts/also-parent', null, ['main' => $main, 'center_list' => $center_list, 'right' => $right, 'lower' => $lower]);
    }
    $html = ob_get_clean();

    wp_send_json_success([
        'html'       => $html,
        'post_count' => 13,
        'has_more'   => $main->max_num_pages > ($offset / 13) + 2,
    ]);
}


function theme_primary_dynamic_nav(){
    $cats = get_categories([
        'parent' => 0,
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
    ]);
    echo '<ul class="primary-menu">';
    foreach ($cats as $c) {
        $class = '';
        if (is_category($c->term_id)) $class = ' class="current"';
        echo '<li'.$class.'><a href="'.esc_url(get_category_link($c)).'">'.esc_html($c->name).'</a></li>';
    }
    echo '</ul>';
}

function theme_secondary_dynamic_nav(){
    $current = get_queried_object();
    $parent_cat_id = 0;
    if ($current && isset($current->term_id)) {
        $term = get_category($current->term_id);
        if ($term && $term->parent) $parent_cat_id = (int) $term->parent; else $parent_cat_id = (int) $term->term_id;
    }
    $args = [
        'orderby' => 'name',
        'order' => 'ASC',
        'hide_empty' => false,
    ];
    $args['parent'] = $parent_cat_id;
    $cats = get_categories($args);
    echo '<ul class="secondary-menu">';
    foreach ($cats as $c) {
        $class = '';
        $desc = (int) get_query_var('cat');
        $is_ancestor = false;
        if (function_exists('cat_is_ancestor_of')) {
            $is_ancestor = cat_is_ancestor_of($c->term_id, $desc);
        } elseif (function_exists('term_is_ancestor_of')) {
            $is_ancestor = term_is_ancestor_of($c->term_id, $desc, 'category');
        } else {
            $is_ancestor = false;
        }
        if (is_category($c->term_id) || (is_category() && $is_ancestor)) {
            $class = ' class="current"';
        }
        echo '<li'.$class.'><a href="'.esc_url(get_category_link($c)).'">'.esc_html($c->name).'</a></li>';
    }
    echo '</ul>';
}
?>
