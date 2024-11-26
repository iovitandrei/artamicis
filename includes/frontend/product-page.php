<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

if ( have_posts() ) :
    while ( have_posts() ) : the_post();
        $product_id = get_the_ID();
        $product_name = get_the_title();
        $product_description = get_the_content();
        $product_price = get_post_meta($product_id, '_product_price', true);
        $product_currency = get_post_meta($product_id, '_product_currency', true);
        $product_stock = get_post_meta($product_id, '_product_stock', true);
        $product_characteristics = get_post_meta($product_id, '_product_characteristics', true);
        $product_gallery_images = get_post_meta($product_id, '_product_gallery_images', true);
        ?>
        <div class="product-page">
            <div class="product-left-column">
                <h1><?php echo esc_html($product_name); ?></h1>
                <div class="product-description">
                    <?php echo wpautop($product_description); ?>
                </div>
                <div class="product-gallery">
                    <div class="featured-image">
                        <?php echo get_the_post_thumbnail($product_id, 'large'); ?>
                    </div>
                    <div class="gallery-images">
                        <?php
                        if ( $product_gallery_images ) {
                            foreach ( $product_gallery_images as $image_id ) {
                                echo wp_get_attachment_image($image_id, 'thumbnail', false, array('class' => 'gallery-thumbnail'));
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="product-right-column">
                <div class="product-price">
                    <?php echo esc_html($product_price) . ' ' . esc_html($product_currency); ?>
                </div>
                <div class="product-characteristics">
                    <?php
                    if ( $product_characteristics ) {
                        echo '<ul>';
                        foreach ( $product_characteristics as $characteristic ) {
                            echo '<li>' . esc_html($characteristic) . '</li>';
                        }
                        echo '</ul>';
                    }
                    ?>
                </div>
                <div class="product-stock">
                    <?php echo esc_html__('Stoc:', 'custom-shop') . ' ' . esc_html($product_stock); ?>
                </div>
                <div class="add-to-cart">
                    <button class="add-to-cart-button" data-product-id="<?php echo esc_attr($product_id); ?>"><?php echo esc_html__('Adaugă în coș', 'custom-shop'); ?></button>
                </div>
            </div>
        </div>
        <?php
    endwhile;
endif;

get_footer();

?>
