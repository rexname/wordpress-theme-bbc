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
});

add_action('after_setup_theme', function(){
    add_image_size('hero-lg', 900, 500, true);
    add_image_size('hero-side', 420, 240, true);
    add_image_size('card-sm', 180, 120, true);
});

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
        if (is_category($c->term_id) || (is_category() && cat_is_ancestor_of($c->term_id, get_query_var('cat')))) {
            $class = ' class="current"';
        }
        echo '<li'.$class.'><a href="'.esc_url(get_category_link($c)).'">'.esc_html($c->name).'</a></li>';
    }
    echo '</ul>';
}
?>
