<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Include scripturile necesare pentru administrare
function custom_shop_enqueue_admin_scripts($hook) {
    if (strpos($hook, 'custom-shop') !== false) {
        wp_enqueue_media(); // Biblioteca media WordPress
        wp_enqueue_script(
            'custom-shop-admin-js',
            plugin_dir_url(__FILE__) . '../assets/js/admin.js',
            ['jquery'],
            null,
            true
        );
    }
}
add_action('admin_enqueue_scripts', 'custom_shop_enqueue_admin_scripts');

// Handle adăugare produs
function custom_shop_handle_add_product() {
    if (isset($_POST['custom_shop_add_product'])) {
        $name = sanitize_text_field($_POST['product_name']);
        $description = sanitize_textarea_field($_POST['product_description']);
        $author = sanitize_text_field($_POST['product_author']);
        $category = intval($_POST['product_category']);
        $price = floatval($_POST['product_price']);
        $currency = sanitize_text_field($_POST['product_currency']);
        $stock = intval($_POST['product_stock']);
        $featured_image = intval($_POST['product_featured_image']);
        $gallery_images = isset($_POST['product_gallery_images']) ? explode(',', sanitize_text_field($_POST['product_gallery_images'])) : [];

        $product_data = [
            'post_title' => $name,
            'post_content' => $description,
            'post_status' => 'publish',
            'post_type' => 'product',
            'post_author' => get_current_user_id()
        ];

        $product_id = wp_insert_post($product_data);

        if (!is_wp_error($product_id)) {
            wp_set_post_terms($product_id, [$category], 'product_cat');
            update_post_meta($product_id, '_product_author', $author);
            update_post_meta($product_id, '_product_price', $price);
            update_post_meta($product_id, '_product_currency', $currency);
            update_post_meta($product_id, '_product_stock', $stock);
            update_post_meta($product_id, '_gallery', $gallery_images);
            if ($featured_image) {
                set_post_thumbnail($product_id, $featured_image);
            }
            echo '<div class="notice notice-success is-dismissible"><p>Produs adăugat cu succes!</p></div>';
        } else {
            echo '<div class="notice notice-error is-dismissible"><p>Eroare la adăugarea produsului.</p></div>';
        }
    }
}

?>

<div class="wrap">
    <h1><?php _e('Adaugă Produs', 'custom-shop'); ?></h1>
    <form method="post">
        <?php custom_shop_handle_add_product(); ?>
        <table class="form-table">
            <tr>
                <th><label for="product_name"><?php _e('Nume Produs', 'custom-shop'); ?></label></th>
                <td><input name="product_name" type="text" id="product_name" class="regular-text" required></td>
            </tr>
            <tr>
                <th><label for="product_description"><?php _e('Descriere', 'custom-shop'); ?></label></th>
                <td><textarea name="product_description" id="product_description" rows="5" class="large-text"></textarea></td>
            </tr>
            <tr>
                <th><label for="product_author"><?php _e('Autor', 'custom-shop'); ?></label></th>
                <td><input name="product_author" type="text" id="product_author" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="product_category"><?php _e('Categorie', 'custom-shop'); ?></label></th>
                <td>
                    <select name="product_category" id="product_category">
                        <?php
                        $categories = get_terms(['taxonomy' => 'product_cat', 'hide_empty' => false]);
                        foreach ($categories as $category) {
                            echo '<option value="' . esc_attr($category->term_id) . '">' . esc_html($category->name) . '</option>';
                        }
                        ?>
                    </select>
                </td>
            </tr>
                <th><label for="product_featured_image"><?php _e('Imagine Reprezentativă', 'custom-shop'); ?></label></th>
                <td>
                    <input type="hidden" name="product_featured_image" id="product_featured_image">
                    <button type="button" id="upload_featured_image_button" class="button"><?php _e('Selectează Imagine', 'custom-shop'); ?></button>
                    <div id="featured_image_preview"></div>
                </td>
            </tr>
            <tr>
                <th><label for="product_gallery_images"><?php _e('Galerie', 'custom-shop'); ?></label></th>
                <td>
                    <input type="hidden" name="product_gallery_images" id="product_gallery_images">
                    <button type="button" id="upload_gallery_images_button" class="button"><?php _e('Selectează Imagini', 'custom-shop'); ?></button>
                    <div id="gallery_images_preview"></div>
                </td>
            </tr>
            <tr>
                <th><label for="product_price"><?php _e('Preț', 'custom-shop'); ?></label></th>
                <td>
                    <input name="product_price" type="number" step="0.01" id="product_price" class="regular-text">
                    <select name="product_currency">
                        <option value="EUR">EUR</option>
                        <option value="USD">USD</option>
                        <option value="RON">RON</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="product_stock"><?php _e('Stoc', 'custom-shop'); ?></label></th>
                <td><input name="product_stock" type="number" id="product_stock" class="regular-text"></td>
            </tr>
        </table>
        <p class="submit">
            <input type="submit" name="custom_shop_add_product" class="button button-primary" value="<?php _e('Adaugă Produs', 'custom-shop'); ?>">
        </p>
    </form>
</div>

<script>
jQuery(document).ready(function ($) {
    var mediaUploader;

    $('#upload_featured_image_button').click(function (e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media({
            title: 'Selectează Imagine',
            button: {
                text: 'Folosește această imagine'
            },
            multiple: false
        });
        mediaUploader.on('select', function () {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#product_featured_image').val(attachment.id);
            $('#featured_image_preview').html('<img src="' + attachment.url + '" style="max-width: 100px;">');
        });
        mediaUploader.open();
    });

    $('#upload_gallery_images_button').click(function (e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media({
            title: 'Selectează Imagini',
            button: {
                text: 'Adaugă la galerie'
            },
            multiple: true
        });
        mediaUploader.on('select', function () {
            var attachments = mediaUploader.state().get('selection').toJSON();
            var ids = [];
            $('#gallery_images_preview').html('');
            attachments.forEach(function (attachment) {
                ids.push(attachment.id);
                $('#gallery_images_preview').append('<img src="' + attachment.url + '" style="max-width: 100px; margin-right: 10px;">');
            });
            $('#product_gallery_images').val(ids.join(','));
        });
        mediaUploader.open();
    });
});
</script>
