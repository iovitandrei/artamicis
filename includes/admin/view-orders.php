<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function custom_shop_delete_order() {
    if ( isset($_GET['action']) && $_GET['action'] == 'delete' && isset($_GET['order_id']) ) {
        $order_id = intval($_GET['order_id']);
        wp_delete_post($order_id, true);
        echo '<div class="notice notice-success is-dismissible"><p>Comanda a fost ștearsă cu succes!</p></div>';
    }
}

custom_shop_delete_order();

$args = array(
    'post_type' => 'shop_order',
    'posts_per_page' => -1
);
$orders = new WP_Query($args);
?>

<div class="wrap">
    <h1><?php _e( 'Comenzi', 'custom-shop' ); ?></h1>
    <table class="wp-list-table widefat fixed striped orders">
        <thead>
            <tr>
                <th scope="col" id="order_number" class="manage-column column-order-number column-primary"><?php _e( 'Nr. Comandă', 'custom-shop' ); ?></th>
                <th scope="col" id="order_status" class="manage-column column-order-status"><?php _e( 'Status', 'custom-shop' ); ?></th>
                <th scope="col" id="order_details" class="manage-column column-order-details"><?php _e( 'Detalii', 'custom-shop' ); ?></th>
                <th scope="col" id="customer_details" class="manage-column column-customer-details"><?php _e( 'Detalii Client', 'custom-shop' ); ?></th>
                <th scope="col" id="actions" class="manage-column column-actions"><?php _e( 'Acțiuni', 'custom-shop' ); ?></th>
            </tr>
        </thead>
        <tbody id="the-list">
            <?php
            if ( $orders->have_posts() ) :
                while ( $orders->have_posts() ) : $orders->the_post();
                    $order_id = get_the_ID();
                    $order_number = get_post_meta($order_id, '_order_number', true);
                    $order_status = get_post_meta($order_id, '_order_status', true);
                    $order_details = get_post_meta($order_id, '_order_details', true);
                    $customer_details = get_post_meta($order_id, '_customer_details', true);
                    ?>
                    <tr>
                        <td class="order-number column-order-number has-row-actions column-primary" data-colname="<?php _e( 'Nr. Comandă', 'custom-shop' ); ?>">
                            <?php echo $order_number; ?>
                            <div class="row-actions">
                                <span class="edit"><a href="<?php echo admin_url('admin.php?page=custom-shop-edit-order&order_id=' . $order_id); ?>"><?php _e( 'Editează', 'custom-shop' ); ?></a> | </span>
                                <span class="trash"><a href="<?php echo admin_url('admin.php?page=custom-shop-orders&action=delete&order_id=' . $order_id); ?>" class="submitdelete"><?php _e( 'Șterge', 'custom-shop' ); ?></a></span>
                            </div>
                        </td>
                        <td class="order-status column-order-status" data-colname="<?php _e( 'Status', 'custom-shop' ); ?>">
                            <?php echo $order_status; ?>
                        </td>
                        <td class="order-details column-order-details" data-colname="<?php _e( 'Detalii', 'custom-shop' ); ?>">
                            <?php echo nl2br($order_details); ?>
                        </td>
                        <td class="customer-details column-customer-details" data-colname="<?php _e( 'Detalii Client', 'custom-shop' ); ?>">
                            <?php echo nl2br($customer_details); ?>
                        </td>
                        <td class="actions column-actions" data-colname="<?php _e( 'Acțiuni', 'custom-shop' ); ?>">
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-edit-order&order_id=' . $order_id); ?>" class="button"><?php _e( 'Editează', 'custom-shop' ); ?></a>
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-orders&action=delete&order_id=' . $order_id); ?>" class="button"><?php _e( 'Șterge', 'custom-shop' ); ?></a>
                        </td>
                    </tr>
                <?php
                endwhile;
            else :
                ?>
                <tr>
                    <td colspan="5"><?php _e( 'Nu există comenzi adăugate încă.', 'custom-shop' ); ?></td>
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
