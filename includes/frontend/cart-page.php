<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

get_header();

$cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
$cart_total = 0;

?>

<div class="cart-page">
    <div class="cart-left-column">
        <h1><?php echo esc_html__('Coș de Cumpărături', 'custom-shop'); ?></h1>
        <table class="cart-table">
            <thead>
                <tr>
                    <th><?php echo esc_html__('Produs', 'custom-shop'); ?></th>
                    <th><?php echo esc_html__('Preț', 'custom-shop'); ?></th>
                    <th><?php echo esc_html__('Cantitate', 'custom-shop'); ?></th>
                    <th><?php echo esc_html__('Total', 'custom-shop'); ?></th>
                    <th><?php echo esc_html__('Acțiune', 'custom-shop'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ( !empty($cart) ) :
                    foreach ( $cart as $cart_item ) :
                        $product_id = $cart_item['product_id'];
                        $product_quantity = $cart_item['quantity'];
                        $product = get_post($product_id);
                        $product_name = $product->post_title;
                        $product_price = get_post_meta($product_id, '_product_price', true);
                        $product_currency = get_post_meta($product_id, '_product_currency', true);
                        $product_total = $product_price * $product_quantity;
                        $cart_total += $product_total;
                        ?>
                        <tr>
                            <td>
                                <?php echo get_the_post_thumbnail($product_id, array(150, 150)); ?>
                                <p><?php echo esc_html($product_name); ?></p>
                            </td>
                            <td><?php echo esc_html($product_price) . ' ' . esc_html($product_currency); ?></td>
                            <td><?php echo esc_html($product_quantity); ?></td>
                            <td><?php echo esc_html($product_total) . ' ' . esc_html($product_currency); ?></td>
                            <td><button class="remove-from-cart-button" data-product-id="<?php echo esc_attr($product_id); ?>"><?php echo esc_html__('Șterge', 'custom-shop'); ?></button></td>
                        </tr>
                    <?php
                    endforeach;
                else :
                    ?>
                    <tr>
                        <td colspan="5"><?php echo esc_html__('Coșul este gol.', 'custom-shop'); ?></td>
                    </tr>
                <?php
                endif;
                ?>
            </tbody>
        </table>
        <div class="cart-total">
            <p><?php echo esc_html__('Total de Plată:', 'custom-shop') . ' ' . esc_html($cart_total) . ' ' . esc_html($product_currency); ?></p>
        </div>
    </div>
    <div class="cart-right-column">
        <h2><?php echo esc_html__('Detalii Comandă', 'custom-shop'); ?></h2>
        <form id="checkout-form">
            <p>
                <label for="billing_name"><?php echo esc_html__('Nume și Prenume:', 'custom-shop'); ?></label>
                <input type="text" id="billing_name" name="billing_name" required>
            </p>
            <p>
                <label for="billing_address"><?php echo esc_html__('Adresă de Livrare:', 'custom-shop'); ?></label>
                <input type="text" id="billing_address" name="billing_address" required>
            </p>
            <p>
                <label for="billing_phone"><?php echo esc_html__('Număr de Telefon:', 'custom-shop'); ?></label>
                <input type="tel" id="billing_phone" name="billing_phone" required>
            </p>
            <p>
                <label for="billing_email"><?php echo esc_html__('Adresă de Email:', 'custom-shop'); ?></label>
                <input type="email" id="billing_email" name="billing_email" required>
            </p>
            <p>
                <button type="submit" class="checkout-button"><?php echo esc_html__('Finalizare Comandă', 'custom-shop'); ?></button>
            </p>
        </form>
    </div>
</div>

<script>
jQuery(document).ready(function($){
    $('.remove-from-cart-button').click(function(){
        var product_id = $(this).data('product-id');
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: {
                action: 'custom_shop_remove_from_cart',
                product_id: product_id
            },
            success: function(response) {
                location.reload();
            }
        });
    });

    $('#checkout-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            type: 'POST',
            data: $(this).serialize() + '&action=custom_shop_checkout',
            success: function(response) {
                alert('<?php echo esc_html__('Va mulțumim! Comanda dvs a fost trimisă cu succes!', 'custom-shop'); ?>');
                location.reload();
            }
        });
    });
});
</script>

<?php

get_footer();

?>
