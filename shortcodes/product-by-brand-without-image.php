<?php
add_shortcode('pbw-product-by-brand-text', 'pbw_product_by_brand_without_img_ajax_filter');

function pbw_product_by_brand_without_img_ajax_filter($atts) {
    ob_start();
    $atts = shortcode_atts(
            array(
                'style' => '',
            ), $atts);

    $tax = get_taxonomy('product_cat');
    $selected = wp_get_object_terms($post->ID, 'product_cat', array('fields' => 'ids'));
    $hierarchical = $tax->hierarchical;
    ?>
    <div class="woo-brand-no-img-module">
        <div id="taxonomy-product_cat" class="selectdiv">
            <?php
            if ($hierarchical) {
                wp_dropdown_categories(array(
                    'taxonomy' => 'product_cat',
                    'class' => 'pbb-with-text',
                    'hide_empty' => 0,
                    'name' => "product_category",
                    'orderby' => 'name',
                    'hierarchical' => 1,
                    'show_option_all' => "Select Categories"
                ));
            } else {
                ?>
                <select name="product_category" class="widefat">
                    <option value="0">Select Categories</option>
                    <?php foreach (get_terms('product_cat', array('hide_empty' => false)) as $term): ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            }
            ?>
        </div>
        <?php
        //Brands
        $default_brand = array('taxonomy' => 'brands');

        if (!isset($box['args']) || !is_array($box['args']))
            $argss = array();
        else
            $args = $box['args'];

        extract(wp_parse_args($args, $default_brand), EXTR_SKIP);

        $tax = get_taxonomy('brands');
        $selected = wp_get_object_terms($post->ID, 'brands', array('fields' => 'ids'));
        $hierarchical = $tax->hierarchical;
        ?>
        <div id="product-brands" class="selectdiv">
            <?php
            if ($hierarchical) {
                wp_dropdown_categories(array(
                    'taxonomy' => 'brands',
                    'class' => 'productBrand-text',
                    'hide_empty' => 0,
                    'name' => "product_brand",
                    'orderby' => 'name',
                    'hierarchical' => 1,
                    'show_option_all' => "Select Brands"
                ));
            } else {
                ?>
                <select name="product_brand" class="productBrand">
                    <option value="0">Select Categories</option>
                    <?php foreach (get_terms('brands', array('hide_empty' => false)) as $term): ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            } 
            ?>
        </div>
    </div>
    <div class="response"></div>
    <div class="brand-wrapper">
        <?php
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $loop = new WP_Query($args);
        while ($loop->have_posts()) : $loop->the_post();
            $_product = wc_get_product($loop->post->ID);
            ?>
            <div class="brand-details-no-img">
                <div class="wb-brandpro-list-title">
                    <h3><a href="<?php echo esc_url(get_permalink($loop->post->ID)) ?>"><?php esc_attr(the_title()); ?></a></h3>
                </div>
            </div>
        <?php endwhile;
        wp_reset_query();
        ?>
    </div>
    <?php
    return ob_get_clean();
    
}

add_action('wp_ajax_filter_products_by_brand_module_with_text', 'filter_products_by_brand_module_with_text');
add_action('wp_ajax_nopriv_filter_products_by_brand_module_with_text', 'filter_products_by_brand_module_with_text');

function filter_products_by_brand_module_with_text() {
    global $product, $post;
    $prod_cat = sanitize_text_field($_POST['product_category']);
    $prod_brand = sanitize_text_field($_POST['product_brand']);
    $prod_id = sanitize_text_field($_POST['prod_id']);

    if ($prod_cat == 0 || $prod_brand == 0) {
        $relation = 'OR';
    } else {
        $relation = 'AND';
    }

    if (isset($prod_cat) && isset($prod_brand)) {
        ?>
        <div class="brand-wrapper">

            <?php
            $args = array(
                'post_type' => 'product',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'tax_query' => array(
                    'relation' => $relation,
                    array(
                        'taxonomy' => 'product_cat',
                        'field' => 'id',
                        'terms' => $prod_cat
                    ),
                    array(
                        'taxonomy' => 'brands',
                        'field' => 'id',
                        'terms' => $prod_brand
                    ),
                )
            );

            $loop = new WP_Query($args);

            if ($loop->have_posts()) {
                $ids = array();
                while ($loop->have_posts()) : $loop->the_post();
                    $_product = wc_get_product($loop->post->ID);
                    $ids[] = $loop->post->ID;
                    ?>
                    <div class="brand-details-no-img">
                        <div class="wb-brandpro-list-title">
                            <h3><a href="<?php echo esc_url(get_permalink($loop->post->ID)); ?>"><?php esc_attr(the_title()); ?></a></h3>
                        </div>
                    </div>    
                <?php
                endwhile;
            } else { ?>
                <p class="brand-error"><?php _e("No related products found.","product-brands-woocommerce"); ?></p>
            <?php
            }
            ?>
        </div>
        <?php
    }
    wp_die();
}
