<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function custom_shop_handle_add_courier() {
    if ( isset($_POST['custom_shop_add_courier']) ) {
        $name = sanitize_text_field($_POST['courier_name']);
        $price = floatval($_POST['courier_price']);
        $free_shipping_threshold = floatval($_POST['free_shipping_threshold']);
        
        $courier_data = array(
            'post_title' => $name,
            'post_type' => 'courier',
            'post_status' => 'publish'
        );
        
        $courier_id = wp_insert_post($courier_data);
        
        if ( !is_wp_error($courier_id) ) {
            update_post_meta($courier_id, '_courier_price', $price);
            update_post_meta($courier_id, '_free_shipping_threshold', $free_shipping_threshold);
            
            echo '<div class="notice notice-success is-dismissible"><p>Curier adăugat cu succes!</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Eroare la adăugarea curierului!</p></div>';
        }
    }
}

?>

<div class="wrap">
    <h1><?php _e( 'Adaugă Curier', 'custom-shop' ); ?></h1>
    <form method="post">
        <?php custom_shop_handle_add_courier(); ?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="courier_name"><?php _e( 'Nume Curier', 'custom-shop' ); ?></label></th>
                <td><input name="courier_name" type="text" id="courier_name" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="courier_price"><?php _e( 'Preț Transport', 'custom-shop' ); ?></label></th>
                <td><input name="courier_price" type="number" step="0.01" id="courier_price" class="regular-text" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="free_shipping_threshold"><?php _e( 'Prag pentru livrare gratuită', 'custom-shop' ); ?></label></th>
                <td><input name="free_shipping_threshold" type="number" step="0.01" id="free_shipping_threshold" class="regular-text"></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="custom_shop_add_courier" id="submit" class="button button-primary" value="<?php _e( 'Adaugă Curier', 'custom-shop' ); ?>"></p>
    </form>
</div>
