<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function custom_shop_delete_courier() {
    if ( isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['courier_id']) ) {
        $courier_id = intval($_GET['courier_id']);
        wp_delete_post($courier_id, true);
        echo '<div class="notice notice-success is-dismissible"><p>Curierul a fost șters cu succes!</p></div>';
    }
}

custom_shop_delete_courier();

$args = array(
    'post_type' => 'courier',
    'posts_per_page' => -1
);
$couriers = new WP_Query($args);
?>

<div class="wrap">
    <h1><?php _e( 'Curieri', 'custom-shop' ); ?></h1>
    <table class="wp-list-table widefat fixed striped couriers">
        <thead>
            <tr>
                <th scope="col"><?php _e( 'Nume Curier', 'custom-shop' ); ?></th>
                <th scope="col"><?php _e( 'Preț Transport', 'custom-shop' ); ?></th>
                <th scope="col"><?php _e( 'Prag Livrare Gratuită', 'custom-shop' ); ?></th>
                <th scope="col"><?php _e( 'Acțiuni', 'custom-shop' ); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ( $couriers->have_posts() ) :
                while ( $couriers->have_posts() ) : $couriers->the_post();
                    $courier_id = get_the_ID();
                    $courier_name = get_the_title();
                    $courier_price = get_post_meta($courier_id, '_courier_price', true);
                    $free_shipping_threshold = get_post_meta($courier_id, '_free_shipping_threshold', true);
                    ?>
                    <tr>
                        <td><?php echo esc_html($courier_name); ?></td>
                        <td><?php echo esc_html($courier_price); ?></td>
                        <td><?php echo esc_html($free_shipping_threshold ? $free_shipping_threshold : '-'); ?></td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-edit-courier&courier_id=' . $courier_id); ?>" class="button"><?php _e( 'Editează', 'custom-shop' ); ?></a>
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-couriers&action=delete&courier_id=' . $courier_id); ?>" class="button"><?php _e( 'Șterge', 'custom-shop' ); ?></a>
                        </td>
                    </tr>
                <?php
                endwhile;
            else :
                ?>
                <tr>
                    <td colspan="4"><?php _e( 'Nu există curieri adăugați încă.', 'custom-shop' ); ?></td>
                </tr>
            <?php
            endif;
            ?>
        </tbody>
    </table>
</div>

<?php
wp_reset_postdata();
?>
