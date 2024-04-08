<?php
//Show brand name on shop pages
add_action('woocommerce_after_shop_loop_item', 'pbw_show_free_shipping_loop', 5);

function pbw_show_free_shipping_loop() {
    global $product;
    $product_cats = wp_get_post_terms($product->id, array('brands'));
    $cat = array();
    $i = 1;
    if($product_cats) {?>
    <div class="shop-brand">Brands:
        <?php
        foreach ($product_cats as $product_cat) {
            $cat[] = '<a href="' . esc_url(site_url()) . '/brand/' . esc_attr($product_cat->slug) . '">' . esc_attr($product_cat->name) . '</a>';
        }
        echo wp_kses_post(join(', ', $cat));
        ?>
    </div>
    <?php
    }
}

//Show brand after add to cart
add_action('woocommerce_single_product_summary', 'pbw_additional_button', 50);

function pbw_additional_button() {
    global $product;
    $product_brands = wp_get_post_terms($product->id, array('brands'));
    $cat = array();
    $i = 1;
    if($product_brands) {?>
    <div class="product-brand">Brands:
        <?php
        foreach ($product_brands as $product_brand) {
            $cat[] = '<a href="' . esc_url(site_url()) . '/brand/' . esc_attr($product_brand->slug) . '">' . esc_attr($product_brand->name) . '</a>';
        }
        echo wp_kses_post(join(', ', $cat));
        ?>
    </div>
    <?php
    }
}
