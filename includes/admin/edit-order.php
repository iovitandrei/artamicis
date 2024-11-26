<?php
// Funcția pentru afișarea formularului de editare a comenzilor
function custom_shop_edit_order() {
    if (!isset($_GET['order_id'])) {
        return;
    }

    $order_id = intval($_GET['order_id']);
    $order = get_post($order_id);
    if (!$order || $order->post_type !== 'order') {
        return;
    }

    $order_status = get_post_meta($order_id, '_order_status', true);
    $order_customer = get_post_meta($order_id, '_order_customer', true);
    $order_products = get_post_meta($order_id, '_order_products', true);

    ?>
    <div class="wrap">
        <h1><?php _e('Editează Comandă', 'custom-shop'); ?></h1>
        <form method="post" action="admin-post.php">
            <input type="hidden" name="action" value="custom_shop_edit_order">
            <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
            <table class="form-table">
                <tr>
                    <th scope="row">
                        <label for="order_status"><?php _e('Status Comandă', 'custom-shop'); ?></label>
                    </th>
                    <td>
                        <select name="order_status" id="order_status">
                            <option value="in asteptare" <?php selected($order_status, 'in asteptare'); ?>><?php _e('In asteptare', 'custom-shop'); ?></option>
                            <option value="in procesare" <?php selected($order_status, 'in procesare'); ?>><?php _e('In procesare', 'custom-shop'); ?></option>
                            <option value="anulata" <?php selected($order_status, 'anulata'); ?>><?php _e('Anulata', 'custom-shop'); ?></option>
                            <option value="finalizata" <?php selected($order_status, 'finalizata'); ?>><?php _e('Finalizata', 'custom-shop'); ?></option>
                            <option value="livrata" <?php selected($order_status, 'livrata'); ?>><?php _e('Livrata', 'custom-shop'); ?></option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php _e('Detalii Client', 'custom-shop'); ?></label>
                    </th>
                    <td>
                        <p><strong><?php _e('Nume:', 'custom-shop'); ?></strong> <?php echo $order_customer['name']; ?></p>
                        <p><strong><?php _e('Adresă:', 'custom-shop'); ?></strong> <?php echo $order_customer['address']; ?></p>
                        <p><strong><?php _e('Telefon:', 'custom-shop'); ?></strong> <?php echo $order_customer['phone']; ?></p>
                        <p><strong><?php _e('Email:', 'custom-shop'); ?></strong> <?php echo $order_customer['email']; ?></p>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php _e('Produse', 'custom-shop'); ?></label>
                    </th>
                    <td>
                        <ul>
                            <?php
                            if ($order_products) {
                                foreach ($order_products as $product) {
                                    echo '<li>' . esc_html($product['name']) . ' x ' . intval($product['quantity']) . '</li>';
                                }
                            } else {
                                _e('Nu există produse în această comandă.', 'custom-shop');
                            }
                            ?>
                        </ul>
                    </td>
                </tr>
            </table>
            <?php submit_button(__('Salvează Comanda', 'custom-shop')); ?>
        </form>
    </div>
    <?php
}

// Cod pentru a procesa datele formularului de editare a comenzii
function custom_shop_process_edit_order() {
    if (isset($_POST['order_id'])) {
        $order_id = intval($_POST['order_id']);
        $order_status = sanitize_text_field($_POST['order_status']);

        // Cod pentru a salva comanda în baza de date
        update_post_meta($order_id, '_order_status', $order_status);

        // Redirectează la pagina de comenzi
        wp_redirect(admin_url('admin.php?page=custom-shop-orders&message=2'));
        exit;
    }
}
add_action('admin_post_custom_shop_edit_order', 'custom_shop_process_edit_order');
?>
