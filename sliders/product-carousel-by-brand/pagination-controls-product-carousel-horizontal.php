<?php
add_shortcode('pbw-products-by-brand-horizontal-carousel', 'pbw_products_by_brand_horizontal_carousel');

function pbw_products_by_brand_horizontal_carousel($atts) {
    ob_start();
    global $wpdb;
    $atts = shortcode_atts(
            array(
                'style' => '1',
            ),
            $atts
    );

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
    $no_image = plugin_dir_url( dirname(__DIR__) ) . '/img/no-image.png';
    if ($atts['style'] == '1') {
        ?>
        <div class="wb-bx-loading"></div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="hr_slider_1">
            <?php
            if ($loop->have_posts()) : while ($loop->have_posts()) : $loop->the_post();
                    global $product, $woocommerce;

                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
                    $price = $product->get_price_html(); 
                    $rating = $product->get_average_rating();
                    ?>
                    <li style="float: left; list-style: none; position: relative; width: 267.5px; margin-right: 10px;">
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
        <div class="wb-bx-loading"></div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="hr_slider_2">
            <?php
            if ($loop->have_posts()) :
                global $product, $woocommerce;
                while ($loop->have_posts()) : $loop->the_post();
                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
                    $price = $product->get_price_html();
                    ?>
                    <li style="float: left; list-style: none; position: relative; width: 267.5px; margin-right: 10px;">
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
        <div class="wb-bx-loading"></div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="hr_slider_3">
            <?php
            if ($loop->have_posts()) :
                global $product, $woocommerce;
                while ($loop->have_posts()) : $loop->the_post();
                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
                    $price = $product->get_price_html();
                    ?>
                    <li style="float: left; list-style: none; position: relative; width: 267.5px; margin-right: 10px;">
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
    <?php } else if ($atts['style'] == '4') {
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
        <div class="wb-bx-loading"></div>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt" id="hr_slider_4">
            <?php
            if ($loop->have_posts()) :
                global $product, $woocommerce;
                while ($loop->have_posts()) : $loop->the_post();
                    $id = $loop->post->ID;
                    $product = new WC_Product($id);
                    $image = wp_get_attachment_image_src(get_post_thumbnail_id($id), 'thumbnail');
                    $price = $product->get_price_html();
                    ?>
                    <li style="float: left; list-style: none; position: relative; width: 267.5px; margin-right: 10px;">
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
