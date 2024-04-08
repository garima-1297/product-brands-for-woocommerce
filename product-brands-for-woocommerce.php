<?php
/*
  Plugin Name: Product Brands Addon for WooCommerce
  Description: Add brands for products in your shop
  Plugin URI: https://wordpress.org/plugins/product-brands-addon-for-woocommerce/
  Author: Evincedev
  Author URI: http://www.evincedev.com/
  Text Domain: product-brands-woocommerce
  Version: 1.0.0
  License: GPL-3.0+
  License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

global $table_prefix, $wpdb;

function pbw_run_on_activation() {
    if (!is_plugin_active('woocommerce/woocommerce.php') && current_user_can('activate_plugins')) {
        // Stop activation redirect and show error
        wp_die('Sorry, but this plugin requires the Woocommerce to be installed and active. <br><a href="' . admin_url('plugins.php') . '">&laquo; Return to Plugins</a>');
    }
}

register_activation_hook(__FILE__, 'pbw_run_on_activation');

//admin scripts
function pbw_brand_admin_scripts_styles() {
    wp_enqueue_style('brand-admin', plugins_url('assets/css/admin.css', __FILE__), array(), '1.0.0');
}

add_action('admin_enqueue_scripts', 'pbw_brand_admin_scripts_styles');


function pbw_brand_shortocdes_create_menu() {

    $capability = current_user_can('manage_woocommerce') ? 'manage_woocommerce' : 'manage_options';
    add_submenu_page('woocommerce', __('Brand Shortcodes', 'product-brands-woocommerce'), __('Brand Shortcodes', 'product-brands-woocommerce'), $capability, 'pbw_shortcodes', 'pbw_admin_brand_shortcodes_data');
}

add_action('admin_menu', 'pbw_brand_shortocdes_create_menu');

//Add settings menu in plugins listing
function pbw_brand_shortcodes_settings_link($links) {
    $settings_link = '<a href="admin.php?page=pbw_shortcodes">' . __('Settings') . '</a>';
    array_push($links, $settings_link);
    return $links;
}

$plugin = plugin_basename(__FILE__);
add_filter("plugin_action_links_$plugin", 'pbw_brand_shortcodes_settings_link');

function pbw_admin_brand_shortcodes_data(){ ?>
<div class="wrap">
    <h1 class="">Product Brands Addon for WooCommerce Shortcodes</h1>
    <p>1. [pbw-brand-vertical-carousel style="1"] - Brand vertical slider(with image,title & count) with 3 styles. Use 1,2 or 3 to get different layouts.</p>
    <p>2. [pbw-brand-horizontal-carousel-name-count style="1"] - Brand slider with brand name,image and count with different styles. Use 1,2,3(No autoplay) & 4.</p>
    <p>3. [pbw-featured-brand-carousel style="1"] - Featured brand image carousel with two styles use 1 or 2.</p>
    <p>4. [pbw-product-by-brand-image columns="4" price="yes"] - To show product images with brands and price. Also, number of cloumns in a row can be set to 2,3,4 or 6 and price can also be removed by setting it to "no".</p>
    <p>5. [pbw-product-by-brand-text] - List down all the products as per the combination selected in filter.</p>
    <p>6. [pbw-a-to-z-brands title="yes"] - Show brand names and images alphabetically. If only wants to display images then set title="no".</p>
    <p>7. [pbw-products-by-brand-horizontal-carousel style="1"] - There are 4 ways to show sliders so one can use any of the 4 styles by changing style parameter to either 1,2,3 or 4</p>
    <p>8. [pbw-products-by-brand-vertical-carousel style="1"] - There are 3 styles to show products in vertical slider by changing style parameter to either 1,2 or 3</p>
    <p>9. [pbw-brand-thumbnails style="1" title="yes" count="yes"] - Just to display all the brand thumbnails in two styles. Use 1 & featured(to show only featured brands) for style parameters and yes or no for title & count as per requirement.</p>
</div>
<?php
}

//frontend scripts
function pbw_brand_frontend_plugin_scripts_styles() {
    wp_enqueue_style('bootstrap-css', plugins_url('assets/css/bootstrap.css', __FILE__), array(), '1.0.0');
    wp_enqueue_script('brand-frontend', plugins_url('assets/js/frontend.js', __FILE__), array('jquery'), '', true);
    wp_enqueue_script('bxslider-js', plugins_url('assets/js/jquery.bxslider.js', __FILE__), array('jquery'), '', true);

    //BxSlider
    wp_enqueue_style('bxslider-css', plugins_url('assets/css/jquery.bxslider.css', __FILE__) . '?' . time());
    wp_enqueue_style('frontend-css', plugins_url('assets/css/frontend.css', __FILE__), array(), '1.0.0');
}

add_action('wp_enqueue_scripts', 'pbw_brand_frontend_plugin_scripts_styles');

function pbw_woocommerce_brands_data() {
    $labels = array(
        'name' => _x('Brands', 'taxonomy general name'),
        'singular_name' => _x('Brand', 'taxonomy singular name'),
        'search_items' => __('Search Brands'),
        'all_items' => __('All Brands'),
        'parent_item' => __('Parent Brand'),
        'parent_item_colon' => __('Parent Brand:'),
        'edit_item' => __('Edit Brand'),
        'update_item' => __('Update Brand'),
        'add_new_item' => __('Add New Brand'),
        'new_item_name' => __('New Brand Name'),
        'not_found' => __('No Brand found'),
        'menu_name' => __('Brands'),
    );

    // Now register the taxonomy
    register_taxonomy('brands', array('product'), array(
        'hierarchical' => true,
        'labels' => $labels,
        'show_ui' => true,
        'show_in_rest' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'brand', 'with_front' => true, 'hierarchical' => true),
    ));
}

add_action('init', 'pbw_woocommerce_brands_data', 0);

if (!class_exists('PBW_BRANDS_TAX_META')) {

    class PBW_BRANDS_TAX_META {

        public function __construct() {
            //
        }

        public function init() {
            add_action('brands_add_form_fields', array($this, 'pbw_add_brands_image'), 10, 2);
            add_action('created_brands', array($this, 'pbw_save_brands_image'), 10, 2);
            add_action('brands_edit_form_fields', array($this, 'pbw_update_brands_image'), 10, 2);
            add_action('edited_brands', array($this, 'pbw_updated_brands_image'), 10, 2);
            add_action('admin_enqueue_scripts', array($this, 'load_media'));
            add_action('admin_footer', array($this, 'add_script'));
        }

        public function load_media() {
            wp_enqueue_media();
        }

        /*
         * Add a form field in the new brands page
         * @since 1.0.0
         */

        public function pbw_add_brands_image($taxonomy) {
            ?>
            <div class="form-field term-group">
                <label for="brands-image-id"><?php _e('Image', 'product-brands-woocommerce'); ?></label>
                <input type="hidden" id="brands-image-id" name="brands-image-id" class="custom_media_url" value="">
                <div id="brands-image-wrapper"></div>
                <p>
                    <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'product-brands-woocommerce'); ?>" />
                    <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'product-brands-woocommerce'); ?>" />
                </p>
            </div>
            <?php
        }

        /*
         * Save the form field
         * @since 1.0.0
         */

        public function pbw_save_brands_image($term_id, $tt_id) {
            $image = sanitize_text_field($_POST['brands-image-id']);
            if (isset($image) && '' !== $image) {
                add_term_meta($term_id, 'brands-image-id', $image, true);
            }
        }

        /*
         * Edit the form field
         * @since 1.0.0
         */

        public function pbw_update_brands_image($term, $taxonomy) {
            ?>
            <tr class="form-field term-group-wrap">
                <th scope="row">
                    <label for="brands-image-id"><?php _e('Image', 'product-brands-woocommerce'); ?></label>
                </th>
                <td>
                    <?php $image_id = get_term_meta($term->term_id, 'brands-image-id', true); ?>
                    <input type="hidden" id="brands-image-id" name="brands-image-id" value="<?php echo esc_attr($image_id); ?>">
                    <div id="brands-image-wrapper">
                        <?php if ($image_id) { ?>
                            <?php echo wp_get_attachment_image($image_id, 'thumbnail'); ?>
                        <?php }
                        ?>
                    </div>
                    <p>
                        <input type="button" class="button button-secondary ct_tax_media_button" id="ct_tax_media_button" name="ct_tax_media_button" value="<?php _e('Add Image', 'product-brands-woocommerce'); ?>" />
                        <input type="button" class="button button-secondary ct_tax_media_remove" id="ct_tax_media_remove" name="ct_tax_media_remove" value="<?php _e('Remove Image', 'product-brands-woocommerce'); ?>" />
                    </p>
                </td>
            </tr>
            <?php
        }

        /*
         * Update the form field value
         * @since 1.0.0
         */

        public function pbw_updated_brands_image($term_id, $tt_id) {
            $image = sanitize_text_field($_POST['brands-image-id']);
            if (isset($image) && '' !== $image) {
                update_term_meta($term_id, 'brands-image-id', $image);
            } else {
                update_term_meta($term_id, 'brands-image-id', '');
            }
        }

        /*
         * Add script
         * @since 1.0.0
         */

        public function add_script() {
            ?>
            <script>
                jQuery(document).ready(function ($) {
                    function ct_media_upload(button_class) {
                        var _custom_media = true,
                                _orig_send_attachment = wp.media.editor.send.attachment;
                        $('body').on('click', button_class, function (e) {
                            var button_id = '#' + $(this).attr('id');
                            var send_attachment_bkp = wp.media.editor.send.attachment;
                            var button = $(button_id);
                            _custom_media = true;
                            wp.media.editor.send.attachment = function (props, attachment) {
                                if (_custom_media) {
                                    if (attachment.type == 'image') {
                                        $('#brands-image-id').val(attachment.id);
                                        $('#brands-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                                        $('#brands-image-wrapper .custom_media_image').attr('src', attachment.url).css('display', 'block');
                                    }
                                } else {
                                    return _orig_send_attachment.apply(button_id, [props, attachment]);
                                }
                            }
                            wp.media.editor.open(button);
                            return false;
                        });
                    }
                    ct_media_upload('.ct_tax_media_button.button');
                    $('body').on('click', '.ct_tax_media_remove', function () {
                        $('#brands-image-id').val('');
                        $('#brands-image-wrapper').html('<img class="custom_media_image" src="" style="margin:0;padding:0;max-height:100px;float:none;" />');
                    });
                    $(document).ajaxComplete(function (event, xhr, settings) {
                        var queryStringArr = settings.data.split('&');
                        if ($.inArray('action=add-tag', queryStringArr) !== -1) {
                            var xml = xhr.responseXML;
                            $response = $(xml).find('term_id').text();
                            if ($response != "") {
                                // Clear the thumb image
                                $('#brands-image-wrapper').html('');
                                $('input[name = "term_meta[featured]"]').prop('checked', false);
                                setTimeout(function () { location.reload(true); }, 500);
                            }
                        }
                    });
                });
            </script>
            <?php
        }

    }

    $BRANDS_TAX_META = new PBW_BRANDS_TAX_META();
    $BRANDS_TAX_META->init();
}

//Feature brand checkbox
function pbw_taxonomy_edit_meta_field($term) {
    $t_id = $term->term_id;
    $term_meta = get_option("taxonomy_$t_id");
    ?>

    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[featured]" class="featured"><?php _e('Featured:'); ?></label></th>
        <td>
            <input type="hidden" value="0" name="term_meta[featured]">
            <input type="checkbox" <?php echo (!empty($term_meta['featured']) ? ' checked="checked" ' : ''); ?> value="1" name="term_meta[featured]" />
        </td>
    </tr>
    <tr class="form-field">
        <th scope="row" valign="top"><label for="term_meta[url]" class="url"><?php _e('Url:'); ?></label></th>
        <td>
            <input type="text" class="txt_url" value="<?php echo esc_url($term_meta['url']); ?>" name="term_meta[url]" />
        </td>
    </tr>

    <?php
}

add_action('brands_edit_form_fields', 'pbw_taxonomy_edit_meta_field', 10, 2);
add_action('brands_add_form_fields', 'pbw_taxonomy_edit_meta_field', 10, 2);

function pbw_save_taxonomy_custom_meta($term_id) {
    $term = array_map( 'sanitize_text_field', $_POST['term_meta'] );
    if (isset($term)) {
        $t_id = $term_id;
        $term_meta = get_option("taxonomy_$t_id");
        $cat_keys = array_keys($term);
        foreach ($cat_keys as $key) {
            if (isset($term[$key])) {
                $term_meta[$key] = $term[$key];
            }
        }
        update_option("taxonomy_$t_id", $term_meta);
    }
}

add_action('edited_brands', 'pbw_save_taxonomy_custom_meta', 10, 2);
add_action('create_brands', 'pbw_save_taxonomy_custom_meta', 10, 2);

//add column to brands taxonomy
add_action('manage_brands_custom_column', 'pbw_show_brands_meta_info_in_columns', 10, 3);

function pbw_show_brands_meta_info_in_columns($string, $columns, $term_id) {
    $t_id = $term_id;
    switch ($columns) {
        case 'featured':
            $options = get_option("taxonomy_$t_id");
            if ($options['featured'] == 1) {
                echo "Yes";
            } else {
                echo "No";
            }
            break;
        case 'url':
            $options = get_option("taxonomy_$t_id");
            if ($options['url'] == "") {
                echo "--";
            } else {
                echo esc_attr($options['url']);
            }
            break;
        case 'image':
            $image_ids = get_term_meta($t_id, 'brands-image-id', false);
            foreach ($image_ids as $image_id) {
                $img_src = wp_get_attachment_image($image_id, array(40, 40));
                if (empty($image_id)) {
                    echo "";
                } else {
                    echo wp_kses_post($img_src);
                }
            }
            break;
    }
}

add_filter('manage_edit-brands_columns', 'pbw_add_new_brands_columns', 2);

function pbw_add_new_brands_columns($columns) {
    $columns['image'] = __('Image');
    $columns['featured'] = __('Featured');
    $columns['url'] = __('Url');
    return $columns;
}

add_filter('woocommerce_product_tabs', 'pbw_custom_product_tabs');

function pbw_custom_product_tabs($tabs) {

    //Attribute Description tab
    $tabs['Brands'] = array(
        'title' => __('Brands', 'woocommerce'),
        'priority' => 100,
        'callback' => 'pbw_attr_brand_tab_content'
    );

    return $tabs;
}

function pbw_attr_brand_tab_content() {
    $terms = wp_get_object_terms(get_queried_object_id(), 'brands');
    ?>
    <div class="tab-product_brand_tab-content">
        <?php
        foreach ($terms as $term) {
            $options = get_option("taxonomy_$term->term_id");
            if($options['url']){
                $url = $options['url'];
            } else {
                $url = site_url() . '/brand/' . esc_attr($term->slug); 
            }
            $image_id = get_term_meta($term->term_id, 'brands-image-id', true);
            $post_thumbnail_img = wp_get_attachment_image_src($image_id, 'thumbnail');                    
            ?>
            <div>
                <a href="<?php echo esc_url($url); ?>"><?php echo esc_attr($term->name); ?></a>
                <div><?php echo wp_kses_post(term_description($term->term_id, "brands")); ?></div>
                <span><img src="<?php echo esc_url($post_thumbnail_img[0]?$post_thumbnail_img[0]:plugins_url('img/default-brand.png',__FILE__)); ?>" /></span>
            </div>
            <?php
        }
        ?>
    </div>
    <?php
}

function pbw_brands_permalink_archive( $permalink, $term, $taxonomy ){
	// Get the category ID 
	$category_id = $term->term_id;
    $options = get_option("taxonomy_$category_id");
	// Check for desired category 
	if( !empty($options['url'])) {
        $permalink = $options['url'];		
	}

	return esc_url($permalink);
}
add_filter( 'term_link', 'pbw_brands_permalink_archive', 10, 3 );

/*
 * code to show brands on shop pages 
 */
require "shortcodes/shortcode.php";

/*
 *  shortcode to filter the products(only product name) by brands and categories 
 */
require "shortcodes/product-by-brand-without-image.php";

/*
 * shortcode to filter the products(with image and details) by brands and categories 
 */
require "shortcodes/product-by-brand-with-image.php";

/*
 *  a_z brand shortcode and other functions used in plugin to get categories and brands 
 */
require "shortcodes/woocommerce-brand-products.php";

/*
 * shortcode to show list of brand thumbnails with different styles
 */
require "shortcodes/brand-thumbnails.php";

/*
 * Shortcode for brand slider with brand name,image and count with different styles
 */
require "sliders/horizontal/horizontal-carousel-with-name-count.php";

/*
 * Shortcode for brand slider with brand name,image and count with different styles 
 */
require "sliders/vertical/vertical-carousel-with-pagination.php";

/*
 * Shortcode featured brand image carousel with two styles.
 */
require "sliders/horizontal/featured-brands-carousel.php";

/*
 * Shortcode to show brand products in horizontal carousel with different styles
 */
require "sliders/product-carousel-by-brand/pagination-controls-product-carousel-horizontal.php";

/*
 * Shortcode to show brand products in vertical carousel with different styles
 */
require "sliders/product-carousel-by-brand/pagination-controls-product-carousel-vertical.php";
