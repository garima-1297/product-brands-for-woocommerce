<?php

/**
 *
 * Used to get A to Z Brands
 *
 */
add_shortcode('pbw-a-to-z-brands', 'pbw_a_to_z_brands');

function pbw_a_to_z_brands($atts)
{
    global $wpdb;
    $terms = get_terms(array(
        'hide_empty' => 'false',
        'taxonomy'   => 'brands',
        'order'      => 'ASC',
        'orderby'    => 'name',
    ));

    $filter_letters = array();
    $tax_wrap;

    $filter_wrap = '<div id="filter_widget">
                            <h3 class="widget-title">A-z Brands</h3>
                            <div class="wb-filter-style1 wb-brandlist-style1">
                                <div class="wb-alphabet-table">
                                    <div class="wb-other-brands">
                                        <a class="wb-alphabet-item wb-all-alphabet-item letter">ALL</a>';
    foreach ($terms as $t) :
        $brand_images = $wpdb->get_results("SELECT * FROM wp_termmeta WHERE meta_key = 'brands-image-id' AND term_id = $t->term_id");
        $letter = substr($t->name, 0, 1);
        if (!in_array($letter, $filter_letters)) {
            $filter_letters[] = $letter;
            $filter_wrap .= '<a id="letter-' . $letter . '" class="wb-alphabet-item letter">' . $letter . '</a>';
        }
        foreach ($brand_images as $brand_image) {
            $img_url = wp_get_attachment_url($brand_image->meta_value);
            if ($img_url == "") {
                $img_url = plugin_dir_url(dirname(__FILE__)) . 'img/default-brand.png';
            }
            $tax_wrap .= '<div class="wb-allview-item-cnt letter-' . $letter . ' tax-row">';
            $tax_wrap .= '<a href="' . esc_url($url) . '"><img src="' . esc_url($img_url) . '"></a>';
            if ($atts['title'] == 'yes') {
                $tax_wrap .= '<div class="wb-allview-item-title">';
                $tax_wrap .= '<a href="' . esc_url(get_term_link($t)) . '">' . esc_attr($t->name) . '(' . esc_attr($t->count) . ')</a>';
                $tax_wrap .= '</div>';
            }
            $tax_wrap .= '</div>';
        }
    endforeach;
    $filter_wrap .= '</div>';
    $filter_wrap .= '</div>';
    $filter_wrap .= '</div>';
    $filter_wrap .= '</div>';
    ob_start();
    $atts = shortcode_atts(
        array(
            'title' => 'yes',
        ),
        $atts
    );
    echo $filter_wrap;
    echo $tax_wrap;

    return ob_get_clean();
}


/**
 * Used to get Brands of the product
 *
 * @param Int Prod ID 
 * @return string
 */
function getProductBrands($product_id)
{
    try {

        $brands = get_the_terms($product_id, 'brands');

        $terms = [];
        if (!empty($brands)) {
            foreach ($brands as $brand) {
                $options = get_option("taxonomy_$brand->term_id");
                if ($options['url']) {
                    $url = esc_url($options['url']);
                } else {
                    $url = esc_url(get_term_link($brand->term_id));
                }
                array_push($terms, '<a href="' . $url . '">' . esc_attr($brand->name) . '</a>');
            }
        }
        return implode(', ', $terms);
    } catch (Exception $e) {
        echo esc_attr($e->getMessage());
    }
}

function getProductCategories($product_id)
{
    try {
        $categories = get_the_terms($product_id, 'product_cat');

        $terms = [];
        if (!empty($categories)) {
            foreach ($categories as $category) {
                array_push($terms, '<a href="' . esc_url(get_term_link($category->term_id)) . '">' . esc_attr($category->name) . '</a>');
            }
        }
        return implode(', ', $terms);
    } catch (Exception $e) {
        echo esc_attr($e->getMessage());
    }
}

/**
 * Used to get first character of the string
 * @param Array
 * @return Array
 */
function getInitials($term_ids)
{
    try {
        $initials = [];
        foreach ($term_ids as $term_id) {
            $terms = get_term_by('id', $term_id, 'brands');
            $term_name = $terms->name;

            $initials[] = mb_substr($term_name, 0, 1);
        }
        $initials = array_unique($initials);
        sort($initials);
        return $initials;
    } catch (Exception $e) {
        echo esc_attr($e->getMessage());
    }
}

/**
 * Used to get rating of the product
 */
function getProductRating($rating)
{
    try {
        if ($rating > 0) {
            $title = sprintf(__('Rated %s out of 5:', 'woocommerce'), $rating);
        } else {
            $title = 'Rate this product:';
            $rating = 0;
        }
        $rating_html = '</a><a href="' . esc_url(get_the_permalink()) . '#tab-reviews"><div class="star-rating ehi-star-rating"><span style="width:' . (($rating / 5) * 100) . '%"></span></div><span style="font-size: 0.857em;"></span></a>';

        return $rating_html;
    } catch (Exception $e) {
        echo esc_attr($e->getMessage());
    }
}
