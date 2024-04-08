<?php
add_shortcode('pbw-brand-thumbnails', 'pbw_brand_thumbnails_module');

function pbw_brand_thumbnails_module($atts) {
    ob_start();
    $atts = shortcode_atts(
            array(
                'style' => '1',
                'title' => 'yes',
                'count' => 'yes',
            ), $atts);
    global $wpdb;
    ?>
    <?php
    $brands = get_terms('brands');
    if ($atts['style'] == '1') {
        ?>
        <div class="wb-row wb-thumb-wrapper wb-thumb-60 wb-thumb-style1 ">
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
                        $img_url = plugin_dir_url( dirname(__FILE__) ) . 'img/default-brand.png';
                    }
                    ?>
                    <div class="wb-col-xs-12 wb-col-sm-6 wb-col-md-3">
                        <div class="wb-thumb-cnt">
                                <a href="<?php echo esc_url($url); ?>">
                                    <img src="<?php echo esc_url($img_url); ?>">
                                </a>
                            <?php if($atts['title'] == 'yes'){ ?>
                            <div class="wb-thumb-title"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> <?php if($atts['count'] == 'yes'){ ?>(<?php echo esc_attr($brand->count); ?>)<?php } ?></div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    <?php } else if ($atts['style'] == 'featured') { ?>
        <div class="wb-row wb-thumb-wrapper wb-thumb-60 wb-thumb-style1 ">
            <?php
            foreach ($brands as $brand) {
                $brand_images = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE meta_key = 'brands-image-id' AND term_id = $brand->term_id");
                foreach ($brand_images as $brand_image) {
                    $id = $brand_image->term_id;
                    $options = get_option("taxonomy_$brand->term_id");
                    if($options['url']){
                        $url = $options['url'];
                    } else {
                        $url = site_url() . '/brand/' . esc_attr($brand->slug); 
                    }
                    if ($options['featured'] == "1") {
                        $img_url = esc_url(wp_get_attachment_url($brand_image->meta_value));
                        if($img_url == ""){
                            $img_url = plugin_dir_url( dirname(__FILE__) ) . 'img/default-brand.png';
                        }
                        ?>
                        <div class="wb-col-xs-12 wb-col-sm-6 wb-col-md-3">
                            <div class="wb-thumb-cnt">
                                    <a href="<?php echo esc_url($url); ?>">
                                        <img src="<?php echo esc_url($img_url); ?>">
                                    </a>
                                    <?php if($atts['title'] == 'yes'){ ?>
                                    <div class="wb-thumb-title"><a href="<?php echo esc_url($url); ?>" title="<?php echo esc_attr($brand->name); ?>"><?php echo esc_attr($brand->name); ?></a> <?php if($atts['count'] == 'yes'){ ?>(<?php echo esc_attr($brand->count); ?>)<?php } ?></div>
                                    <?php } ?>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
        </div>
    <?php } 
    return ob_get_clean();
}
