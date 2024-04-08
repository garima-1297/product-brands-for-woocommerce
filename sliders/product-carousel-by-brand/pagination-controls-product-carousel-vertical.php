<?php
add_shortcode('pbw-products-by-brand-vertical-carousel', 'pbw_product_by_brand_vertical_slider');

function pbw_product_by_brand_vertical_slider($atts) {
    ob_start();
    global $wpdb;
    $atts = shortcode_atts(
            array(
                'style' => '1',
            ), $atts);

    $brands = get_terms('brands');
    foreach ($brands as $brand) {
        $brand_terms_ids[] = $brand->term_id;
    }

    $args = array(
        'post_type' => 'product',
        'post_status' => 'publish',
        'posts_per_page' => -1,
        'tax_query' => array(
            array(
                'taxonomy' => 'brands',
                'field' => 'id',
                'terms' => $brand_terms_ids
            )
        ),
    );

    $loop = new WP_Query($args);

    $no_image = esc_url(plugins_url('/img/no-image.png', __FILE__ ));
    if ($atts['style'] == '1') {
        ?>
        <?php
        $terms = get_terms('brands');
        $i = 1;
        $separator = ', '; // Include a separator to separate the category
        $count_terms = count($terms);
        ?>
        <div class="wb-brandpro-car-header wb-brandpro-car-header-style3">
            <span>Product Inbrand</span>
            <?php
            foreach ($terms as $term) {
                if ($i != 1) {
                    echo wp_kses_post($separator);
                }
                echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_attr($term->name) . '</a>';
                $i++;
            }
            ?>
        </div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="slider_1">
            <?php
            if ($loop->have_posts()):
                global $product, $woocommerce;
                while ($loop->have_posts()): $loop->the_post();
                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'full');
                    $price = $product->get_price_html();
                    ?>
                    <li style="float: none; list-style: none; position: relative; width: 346.663px; margin-bottom: 10px;">
                        <div class="wb-brandpro-car-cnt">
                            <img width="150" height="150" src="<?php echo esc_url(($image) ? $image[0] : $no_image); ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image">
                            <div class="wb-brandpro-car-detail">
                                <div class="wb-brandpro-car-title">
                                    <h3><a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr(the_title()); ?>"><?php esc_attr(the_title()); ?></a></h3>
                                </div>
                                <div class="wb-brandpro-car-price"><?php echo wp_kses_post($price); ?></div>
                                <?php if (getProductCategories($id) != "") { ?>
                                    <div class="wb-brandpro-car-meta"><span>Categories: </span>
                                        <?php echo wp_kses_post(getProductCategories($id)); ?>
                                    </div>
                                    <?php
                                }
                                if (getProductBrands($id) != "") {
                                    ?>
                                    <div class="wb-brandpro-car-meta"><span>Brands: </span>
                                        <?php echo wp_kses_post(getProductBrands($id)); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                    <?php
                endwhile;
            endif;
            ?>
        </ul>
    <?php } else if ($atts['style'] == '2') {
        ?>
        <?php
        $terms = get_terms('brands');
        $i = 1;
        $separator = ', '; // Include a separator to separate the category
        $count_terms = count($terms);
        ?>
        <div class="wb-brandpro-car-header wb-brandpro-car-header-style2">
            <span>Product Inbrand</span>
            <?php
            foreach ($terms as $term) {
                if ($i != 1) {
                    echo wp_kses_post($separator);
                }
                echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_attr($term->name) . '</a>';
                $i++;
            }
            ?>
        </div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="slider_2">
            <?php
            if ($loop->have_posts()):
                global $product, $woocommerce;
                while ($loop->have_posts()): $loop->the_post();
                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
                    $price = $product->get_price_html();
                    ?>
                    <li style="float: none; list-style: none; position: relative; width: 346.663px; margin-bottom: 10px;">
                        <div class="wb-brandpro-car-cnt">
                            <img width="150" height="150" src="<?php echo esc_url(($image) ? $image[0] : $no_image); ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image">
                            <div class="wb-brandpro-car-detail">
                                <div class="wb-brandpro-car-title">
                                    <h3><a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr(the_title()); ?>"><?php esc_attr(the_title()); ?></a></h3>
                                </div>
                                <div class="wb-brandpro-car-price"><?php echo wp_kses_post($price); ?></div>
                                <?php if (getProductCategories($id) != "") { ?>
                                    <div class="wb-brandpro-car-meta"><span>Categories: </span>
                                        <?php echo wp_kses_post(getProductCategories($id)); ?>
                                    </div>
                                    <?php
                                }
                                if (getProductBrands($id) != "") {
                                    ?>
                                    <div class="wb-brandpro-car-meta"><span>Brands: </span>
                                        <?php echo wp_kses_post(getProductBrands($id)); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                    <?php
                endwhile;
            endif;
            ?>
        </ul>
    <?php } else if ($atts['style'] == '3') {
        ?>
        <?php
        $terms = get_terms('brands');
        $i = 1;
        $separator = ', '; // Include a separator to separate the category
        $count_terms = count($terms);
        ?>
        <div class="wb-brandpro-car-header wb-brandpro-car-header-style1">
        <span>Product Inbrand</span>
            <?php
            foreach ($terms as $term) {
                if ($i != 1) {
                    echo wp_kses_post($separator);
                }
                echo '<a href="' . esc_url(get_term_link($term)) . '">' . esc_attr($term->name) . '</a>';
                $i++;
            }
            ?>
        </div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="slider_3">
            <?php
            if ($loop->have_posts()):
                global $product, $woocommerce;
                while ($loop->have_posts()): $loop->the_post();
                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
                    $price = $product->get_price_html();
                    ?>
                    <li style="float: none; list-style: none; position: relative; width: 346.663px; margin-bottom: 10px;">
                        <div class="wb-brandpro-car-cnt">
                            <img width="150" height="150" src="<?php echo esc_url(($image) ? $image[0] : $no_image); ?>" class="attachment-shop_catalog size-shop_catalog wp-post-image">
                            <div class="wb-brandpro-car-detail">
                                <div class="wb-brandpro-car-title">
                                    <h3><a href="<?php esc_url(the_permalink()); ?>" title="<?php esc_attr(the_title()); ?>"><?php esc_attr(the_title()); ?></a></h3>
                                </div>
                                <div class="wb-brandpro-car-price"><?php echo wp_kses_post($price); ?></div>
                                <?php if (getProductCategories($id) != "") { ?>
                                    <div class="wb-brandpro-car-meta"><span>Categories: </span>
                                        <?php echo wp_kses_post(getProductCategories($id)); ?>
                                    </div>
                                    <?php
                                }
                                if (getProductBrands($id) != "") {
                                    ?>
                                    <div class="wb-brandpro-car-meta"><span>Brands: </span>
                                        <?php echo wp_kses_post(getProductBrands($id)); ?>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                    </li>
                    <?php
                endwhile;
            endif;
            ?>
        </ul>
        <?php
    }
    return ob_get_clean();
}
?>