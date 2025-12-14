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

// Customizer: pilih kategori untuk section ALSO
add_action('customize_register', function($wp_customize){
    $wp_customize->add_section('bbc_also_section', [
        'title' => __('ALSO Section','bbc'),
        'priority' => 130,
    ]);
    $wp_customize->add_setting('bbc_also_category', [
        'default' => 0,
        'sanitize_callback' => 'absint',
    ]);
    $cats = get_categories(['hide_empty'=>false]);
    $choices = [0 => __('Auto','bbc')];
    foreach($cats as $c){ $choices[$c->term_id] = $c->name; }
    $wp_customize->add_control('bbc_also_category', [
        'type' => 'select',
        'section' => 'bbc_also_section',
        'label' => __('Category for ALSO','bbc'),
        'choices' => $choices,
    ]);

    // Multi-category selection
    if (!function_exists('bbc_sanitize_csv_ids')) {
        function bbc_sanitize_csv_ids($value){
            if (is_array($value)) { $ids = $value; }
            else { $ids = preg_split('/\s*,\s*/', (string)$value, -1, PREG_SPLIT_NO_EMPTY); }
            $ids = array_map('absint', $ids);
            $ids = array_filter($ids, function($v){ return $v > 0; });
            $ids = array_unique($ids);
            return implode(',', $ids);
        }
    }
    if (!class_exists('BBC_Customize_Checkbox_Multiple')) {
        class BBC_Customize_Checkbox_Multiple extends WP_Customize_Control {
            public $type = 'checkbox-multiple';
            public function render_content(){
                if (empty($this->choices)) return;
                echo '<span class="customize-control-title">'.esc_html($this->label).'</span>';
                $current = array_map('absint', preg_split('/\s*,\s*/', (string)$this->value(), -1, PREG_SPLIT_NO_EMPTY));
                echo '<div class="bbc-multi-wrap">';
                foreach ($this->choices as $val => $label) {
                    $checked = in_array((int)$val, $current, true) ? ' checked' : '';
                    echo '<label style="display:block;margin:4px 0"><input type="checkbox" class="bbc-multi" value="'.esc_attr($val).'"'.$checked.'> '.esc_html($label).'</label>';
                }
                echo '<input type="hidden" class="bbc-multi-store" '.$this->link().' value="'.esc_attr(implode(',', $current)).'">';
                echo '<script>(function(s){var wrap=s.parentNode;var boxes=wrap.querySelectorAll(".bbc-multi");var store=wrap.querySelector(".bbc-multi-store");boxes.forEach(function(b){b.addEventListener("change",function(){var v=[];boxes.forEach(function(x){if(x.checked) v.push(x.value);});store.value=v.join(",");store.dispatchEvent(new Event("change"));});});})(document.currentScript);</script>';
                echo '</div>';
            }
        }
    }
    $wp_customize->add_setting('bbc_also_categories', [
        'default' => '',
        'sanitize_callback' => 'bbc_sanitize_csv_ids',
    ]);
    $multi_choices = [];
    foreach(get_categories(['hide_empty'=>false,'parent'=>0]) as $c){ $multi_choices[$c->term_id] = $c->name; }
    $wp_customize->add_control(new BBC_Customize_Checkbox_Multiple($wp_customize, 'bbc_also_categories', [
        'section' => 'bbc_also_section',
        'label' => __('Categories for ALSO (multi)','bbc'),
        'choices' => $multi_choices,
    ]));
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
