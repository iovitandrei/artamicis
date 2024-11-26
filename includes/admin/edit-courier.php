<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

function custom_shop_handle_edit_courier() {
    if ( isset($_POST['custom_shop_edit_courier']) && isset($_GET['courier_id']) ) {
        $courier_id = intval($_GET['courier_id']);
        $name = sanitize_text_field($_POST['courier_name']);
        $price = floatval($_POST['courier_price']);
        $free_shipping_threshold = floatval($_POST['free_shipping_threshold']);
        
        $courier_data = array(
            'ID' => $courier_id,
            'post_title' => $name,
            'post_type' => 'courier',
            'post_status' => 'publish'
        );
        
        $updated_courier_id = wp_update_post($courier_data);
        
        if ( !is_wp_error($updated_courier_id) ) {
            update_post_meta($updated_courier_id, '_courier_price', $price);
            update_post_meta($updated_courier_id, '_free_shipping_threshold', $free_shipping_threshold);
            
            echo '<div class="notice notice-success is-dismissible"><p>Curier actualizat cu succes!</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Eroare la actualizarea curierului!</p></div>';
        }
    }
}

if ( isset($_GET['courier_id']) ) {
    $courier_id = intval($_GET['courier_id']);
    $courier = get_post($courier_id);
    $courier_name = $courier->post_title;
    $courier_price = get_post_meta($courier_id, '_courier_price', true);
    $free_shipping_threshold = get_post_meta($courier_id, '_free_shipping_threshold', true);
} else {
    wp_die('Curierul nu a fost găsit.');
}

?>

<div class="wrap">
    <h1><?php _e( 'Editează Curier', 'custom-shop' ); ?></h1>
    <form method="post">
        <?php custom_shop_handle_edit_courier(); ?>
        <table class="form-table">
            <tr>
                <th scope="row"><label for="courier_name"><?php _e( 'Nume Curier', 'custom-shop' ); ?></label></th>
                <td><input name="courier_name" type="text" id="courier_name" class="regular-text" value="<?php echo esc_attr($courier_name); ?>" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="courier_price"><?php _e( 'Preț Transport', 'custom-shop' ); ?></label></th>
                <td><input name="courier_price" type="number" step="0.01" id="courier_price" class="regular-text" value="<?php echo esc_attr($courier_price); ?>" required></td>
            </tr>
            <tr>
                <th scope="row"><label for="free_shipping_threshold"><?php _e( 'Prag pentru livrare gratuită', 'custom-shop' ); ?></label></th>
                <td><input name="free_shipping_threshold" type="number" step="0.01" id="free_shipping_threshold" class="regular-text" value="<?php echo esc_attr($free_shipping_threshold); ?>"></td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="custom_shop_edit_courier" id="submit" class="button button-primary" value="<?php _e( 'Actualizează Curier', 'custom-shop' ); ?>"></p>
    </form>
</div>
