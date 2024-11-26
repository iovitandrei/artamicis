<?php
if (!defined('ABSPATH')) {
    exit; // Ieși dacă fișierul este accesat direct
}

// Query pentru lista de produse
$args = [
    'post_type' => 'product',
    'posts_per_page' => -1,
];
$products = new WP_Query($args);

?>
<div class="wrap">
    <h1><?php _e('Produse', 'custom-shop'); ?></h1>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('Imagine', 'custom-shop'); ?></th>
                <th><?php _e('Nume Produs', 'custom-shop'); ?></th>
                <th><?php _e('Categorie', 'custom-shop'); ?></th>
                <th><?php _e('Autor', 'custom-shop'); ?></th>
                <th><?php _e('Preț', 'custom-shop'); ?></th>
                <th><?php _e('Stoc', 'custom-shop'); ?></th>
                <th><?php _e('Acțiuni', 'custom-shop'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($products->have_posts()) : ?>
                <?php while ($products->have_posts()) : $products->the_post(); ?>
                    <?php
                    $product_id = get_the_ID();

                    // Preluare metadate produs
                    $author = get_post_meta($product_id, '_product_author', true) ?: __('Necunoscut', 'custom-shop');
                    $price = get_post_meta($product_id, '_product_price', true) ?: __('N/A', 'custom-shop');
                    $currency = get_post_meta($product_id, '_product_currency', true) ?: __('LEI', 'custom-shop');
                    $stock = get_post_meta($product_id, '_product_stock', true);
                    $stock_display = isset($stock) ? esc_html($stock) : __('Indisponibil', 'custom-shop');

                    // Preluare imagine reprezentativă
                    $featured_image = get_the_post_thumbnail($product_id, 'thumbnail', ['class' => 'product-thumbnail']);
                    if (!$featured_image) {
                        $featured_image = __('Fără imagine', 'custom-shop');
                    }

                    // Preluare categorie
                    $categories = get_the_terms($product_id, 'product_cat');
                    $category_name = ($categories && !is_wp_error($categories)) ? $categories[0]->name : __('Fără categorie', 'custom-shop');
                    ?>
                    <tr>
                        <td><?php echo $featured_image; ?></td>
                        <td><?php echo esc_html(get_the_title()); ?></td>
                        <td><?php echo esc_html($category_name); ?></td>
                        <td><?php echo esc_html($author); ?></td>
                        <td><?php echo esc_html($price . ' ' . $currency); ?></td>
                        <td><?php echo $stock_display; ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-edit-product&product_id=' . $product_id); ?>" class="button"><?php _e('Editează', 'custom-shop'); ?></a>
                            <a href="<?php echo get_permalink($product_id); ?>" class="button" target="_blank"><?php _e('Vezi Produs', 'custom-shop'); ?></a>
                            <a href="<?php echo wp_nonce_url(admin_url('admin.php?page=custom-shop-delete-product&product_id=' . $product_id), 'delete_product_' . $product_id); ?>" class="button"><?php _e('Șterge', 'custom-shop'); ?></a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else : ?>
                <tr>
                    <td colspan="7"><?php _e('Nu există produse.', 'custom-shop'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<?php
// Resetare date query
wp_reset_postdata();
?>
