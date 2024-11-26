<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

$categories = get_terms(array(
    'taxonomy' => 'product_cat',
    'hide_empty' => true
));

?>

<div class="shop-page">
    <h1><?php echo esc_html__('Magazin', 'custom-shop'); ?></h1>
    <div class="categories">
        <?php
        foreach ( $categories as $category ) {
            ?>
            <div class="category">
                <h2><?php echo esc_html($category->name); ?></h2>
                <?php
                $products = new WP_Query(array(
                    'post_type' => 'product',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'product_cat',
                            'field' => 'term_id',
                            'terms' => $category->term_id,
                        ),
                    ),
                ));

                if ( $products->have_posts() ) {
                    echo '<div class="products">';
                    while ( $products->have_posts() ) {
                        $products->the_post();
                        $product_id = get_the_ID();
                        $product_name = get_the_title();
                        $product_price = get_post_meta($product_id, '_product_price', true);
                        $product_currency = get_post_meta($product_id, '_product_currency', true);
                        ?>
                        <div class="product">
                            <a href="<?php the_permalink(); ?>">
                                <?php the_post_thumbnail('medium'); ?>
                                <h3><?php echo esc_html($product_name); ?></h3>
                                <p><?php echo esc_html($product_price) . ' ' . esc_html($product_currency); ?></p>
                            </a>
                            <button class="add-to-cart-button" data-product-id="<?php echo esc_attr($product_id); ?>"><?php echo esc_html__('Adaugă în coș', 'custom-shop'); ?></button>
                            <button class="add-to-wishlist-button" data-product-id="<?php echo esc_attr($product_id); ?>"><?php echo esc_html__('Adaugă în Wish List', 'custom-shop'); ?></button>
                        </div>
                        <?php
                    }
                    echo '</div>';
                } else {
                    echo '<p>' . esc_html__('Nu există produse în această categorie.', 'custom-shop') . '</p>';
                }

                wp_reset_postdata();
                ?>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<script>
jQuery(document).ready(function($){
    $('.add-to-cart-button').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'custom_shop_add_to_cart',
                product_id: product_id
            },
            success: function(response) {
                alert('<?php echo esc_html__('Produsul a fost adăugat în coș!', 'custom-shop'); ?>');
            }
        });
    });

    $('.add-to-wishlist-button').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'custom_shop_add_to_wishlist',
                product_id: product_id
            },
            success: function(response) {
                alert('<?php echo esc_html__('Produsul a fost adăugat în lista de preferințe!', 'custom-shop'); ?>');
            }
        });
    });
});
</script>

<?php

get_footer();

?>
