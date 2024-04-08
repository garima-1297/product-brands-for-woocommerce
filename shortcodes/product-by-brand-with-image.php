<?php
add_shortcode('pbw-product-by-brand-image', 'pbw_product_by_brand_with_ajax_filter');

function pbw_product_by_brand_with_ajax_filter($atts) {
    ob_start();
    $atts = shortcode_atts(
            array(
                'columns' => '4',
                'price' => 'yes',
            ), $atts);

    $tax = get_taxonomy('product_cat');
    $selected = wp_get_object_terms($post->ID, 'product_cat', array('fields' => 'ids'));
    $hierarchical = $tax->hierarchical;
    ?>
    <div class="woo-brand-module">
        <div id="taxonomy-product_cat" class="selectdiv">
            <?php
            if ($hierarchical) {
                wp_dropdown_categories(array(
                    'taxonomy' => 'product_cat',
                    'class' => 'widefat',
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
                    'class' => 'productBrand',
                    'hide_empty' => 0,
                    'name' => "product_brand",
                    'orderby' => 'name',
                    'hierarchical' => 1,
                    'show_option_all' => "Select Brands"
                ));
            } else {
                ?>
                <select name="product_brand" class="productBrand">
                    <option value="0">Select Brands</option>
                    <?php foreach (get_terms('brands', array('hide_empty' => false)) as $term): ?>
                        <option value="<?php echo esc_attr($term->term_id); ?>"><?php echo esc_html($term->name); ?></option>
                    <?php endforeach; ?>
                </select>
                <?php
            }
            ?>
        </div>
    </div>
    <div class="prod-response"></div>
    <div class="all-products woocommerce columns-<?php echo esc_attr($atts['columns']); ?>">
        <ul class="products columns-<?php echo esc_attr($atts['columns']); ?>">
        <?php
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1
        );

        $loop = new WP_Query($args);
        $ids = array();
        while ($loop->have_posts()) : $loop->the_post();
            $_product = wc_get_product($loop->post->ID);
            $ids[] = $loop->post->ID;
            ?>
            <li class="product type-product post-99 status-publish first instock product_cat-music product_cat-singles has-post-thumbnail sale shipping-taxable purchasable product-type-simple"> 

                <a href="<?php echo esc_url(get_permalink($loop->post->ID)); ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                    <?php woocommerce_show_product_sale_flash($post, $product);
                    if (has_post_thumbnail($loop->post->ID))
                        echo wp_kses_post(get_the_post_thumbnail($loop->post->ID, 'shop_catalog'),'product-brands-woocommerce');
                    else
                        echo '<img src="' . esc_url(woocommerce_placeholder_img_src()) . '" alt="Placeholder" width="300px" height="300px" />';
                    ?>                
                </a>
                <div class="brand-details">
                    <h3><a href="<?php echo esc_url(get_permalink($loop->post->ID)); ?>"><?php esc_attr_e(the_title()); ?></a></h3>
            <?php if ($atts['price'] == "yes") { ?>
                <?php echo wp_kses_post($_product->get_price_html());
            }
            ?>
                </div>
        </li>
        <?php endwhile;
    ?>
        <input type="hidden" name="column" value="<?php echo esc_attr($atts['columns']); ?>"/>
        <input type="hidden" name="price" value="<?php echo esc_attr($atts['price']); ?>"/>
         </ul>
    </div>
   

    <?php
    return ob_get_clean();
}

add_action('wp_ajax_pbw_filter_products_by_brand_module', 'pbw_filter_products_by_brand_module');
add_action('wp_ajax_nopriv_pbw_filter_products_by_brand_module', 'pbw_filter_products_by_brand_module');

function pbw_filter_products_by_brand_module() {
    global $product, $post;
    $prod_cat = sanitize_text_field($_POST['product_category']);
    $prod_brand = sanitize_text_field($_POST['product_brand']);
    $column = sanitize_text_field($_POST['column']);
    $price = sanitize_text_field($_POST['price']);

    if ($prod_cat == 0 || $prod_brand == 0) {
        $relation = 'OR';
    } else {
        $relation = 'AND';
    }

    if (isset($prod_cat) && isset($prod_brand)) {
        ?>
        <div class="woocommerce columns-<?php echo $column; ?>">
        <ul class="products columns-<?php echo $column; ?>">
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
                while ($loop->have_posts()) : $loop->the_post();
                    $_product = wc_get_product($loop->post->ID);
                    ?>
                    <li class="product type-product post-99 status-publish first instock product_cat-music product_cat-singles has-post-thumbnail sale shipping-taxable purchasable product-type-simple"> 

                        <a href="<?php echo esc_url(get_permalink($loop->post->ID)) ?>" title="<?php echo esc_attr($loop->post->post_title ? $loop->post->post_title : $loop->post->ID); ?>">
                            <?php woocommerce_show_product_sale_flash($post, $product);
                            if (has_post_thumbnail($loop->post->ID))
                                echo wp_kses_post(get_the_post_thumbnail($loop->post->ID, 'shop_catalog'),'product-brands-woocommerce');
                            else
                                echo wp_kses_post('<img src="' . esc_url(woocommerce_placeholder_img_src()) . '" alt="Placeholder" width="300px" height="300px" />');
                            ?>                
                        </a>
                        <div class="brand-details">
                            <h3><a href="<?php echo esc_url(get_permalink($loop->post->ID)) ?>"><?php esc_attr(the_title()); ?></a></h3>
                    <?php
                    if ($price == "yes") {
                        echo wp_kses_post($_product->get_price_html());
                    }
                    ?>
                        </div>
                </li>

            <?php endwhile;
        } else { ?>
            <p class="brand-error"><?php _e("No related products found.","product-brands-woocommerce"); ?></p>
        <?php
        }
        ?>
        </ul>
        </div>
        

    <?php
    }
    wp_die();
}
