<?php
add_shortcode('pbw-brand-horizontal-carousel-name-count', 'pbw_brand_slider_with_name_count');

function pbw_brand_slider_with_name_count($atts) {
    ob_start();
    $atts = shortcode_atts(
            array(
                'style' => '1',
            ), $atts);

    global $wpdb;
    $brands = get_terms('brands');

    if ($atts['style'] == '1') {
        ?>
        <ul class="wb-bxslider wb-car-car  wb-carousel-layout wb-car-cnt " id="hr_slider_5">
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
                    <li style="float: left; list-style: none; position: relative; width: 212px; margin-right: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <div class="wb-car-title"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> (<?php echo $brand->count; ?>)</div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php } else if ($atts['style'] == '2') { ?>
        <ul class="wb-bxslider wb-car-car  wb-carousel-layout wb-car-cnt " id="hr_slider_6">
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
                    <li style="float: left; list-style: none; position: relative; width: 212px; margin-right: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php } else if ($atts['style'] == '3') { ?>
        <ul class="wb-bxslider wb-car-car  wb-carousel-layout wb-car-cnt " id="hr_slider_7">
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
                    <li style="float: left; list-style: none; position: relative; width: 212px; margin-right: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <div class="wb-car-title"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> (<?php echo $brand->count; ?>)</div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php } else if ($atts['style'] == '4') { ?>
        <ul class="wb-bxslider wb-car-car  wb-carousel-layout wb-car-cnt " id="hr_slider_8">
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
                    <li style="float: left; list-style: none; position: relative; width: 212px; margin-right: 10px;">
                        <div class="wb-car-item-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <div class="wb-car-title"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> (<?php echo $brand->count; ?>)</div>
                        </div>
                    </li>
                    <?php
                }
            }
            ?>
        </ul>
    <?php } ?>
    <?php
    $output = ob_get_contents();
    ob_end_clean();
    return $output;
}
