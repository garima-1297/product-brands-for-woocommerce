<?php
add_shortcode('pbw-brand-vertical-carousel', 'pbw_brand_vertical_slider');

function pbw_brand_vertical_slider($atts) {
    ob_start();
    global $wpdb;
    $atts = shortcode_atts(
            array(
                'style' => '1',
            ), $atts);

    $brands = get_terms('brands');

    if ($atts['style'] == '1') {
        ?>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt " id="vt_slider_1">
            <?php
            foreach ($brands as $brand) {
                $options = get_option("taxonomy_$brand->term_id");
                if($options['url']){
                    $url = $options['url'];
                } else {
                    $url = site_url() . '/brand/' . esc_attr($brand->slug); 
                }
                $brand_images = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE meta_key = 'brands-image-id' AND term_id = $brand->term_id");
                foreach ($brand_images as $brand_image) {
                    $img_url = wp_get_attachment_url($brand_image->meta_value);
                    if($img_url == ""){
                        $img_url = plugin_dir_url( dirname(__DIR__) ) . '/img/default-brand.png';
                    }
                    ?>
                    <li style="float: none; list-style: none; position: relative; width: 346.663px; margin-bottom: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <div class="wb-car-title"><a href="<?php echo esc_url($url); ?>"title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> (<?php echo esc_attr($brand->count); ?>)</div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php } else if ($atts['style'] == '2') { ?>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt " id="vt_slider_2">
            <?php
            foreach ($brands as $brand) {
                $options = get_option("taxonomy_$brand->term_id");
                if($options['url']){
                    $url = $options['url'];
                } else {
                    $url = site_url() . '/brand/' . esc_attr($brand->slug); 
                }
                $brand_images = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE meta_key = 'brands-image-id' AND term_id = $brand->term_id");
                foreach ($brand_images as $brand_image) {
                    $img_url = wp_get_attachment_url($brand_image->meta_value);
                    if($img_url == ""){
                        $img_url = plugin_dir_url( dirname(__DIR__) ) . '/img/default-brand.png';
                    }
                    ?>
                    <li style="float: none; list-style: none; position: relative; width: 346.663px; margin-bottom: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <div class="wb-car-title"><a href="<?php echo esc_url($url); ?>"title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> (<?php echo esc_attr($brand->count); ?>)</div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php } else if ($atts['style'] == '3') {
        ?>
        <ul class="wb-bxslider wb-car-car wb-carousel-layout wb-car-cnt " id="vt_slider_3">
            <?php
            foreach ($brands as $brand) {
                $options = get_option("taxonomy_$brand->term_id");
                if($options['url']){
                    $url = $options['url'];
                } else {
                    $url = site_url() . '/brand/' . esc_attr($brand->slug); 
                }
                $brand_images = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE meta_key = 'brands-image-id' AND term_id = $brand->term_id");
                ?>
                <?php
                foreach ($brand_images as $brand_image) {
                    $img_url = wp_get_attachment_url($brand_image->meta_value);
                    if($img_url == ""){
                        $img_url = plugin_dir_url( dirname(__DIR__) ) . '/img/default-brand.png';
                    }
                    ?>
                    <li style="float: none; list-style: none; position: relative; width: 346.663px; margin-bottom: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <div class="wb-car-title"><a href="<?php echo esc_url($url); ?>"title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> (<?php echo esc_attr($brand->count); ?>)</div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php }
    return ob_get_clean();
}
