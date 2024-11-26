<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function custom_shop_delete_product() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Nu ai permisiunea de a accesa această pagină.', 'custom-shop'));
    }

    // Preia ID-ul produsului
    $product_id = isset($_GET['product_id']) ? intval($_GET['product_id']) : 0;

    // Verifică validitatea nonce-ului
    if (!isset($_GET['_wpnonce']) || !wp_verify_nonce($_GET['_wpnonce'], 'delete_product_' . $product_id)) {
        wp_die(__('Solicitarea nu este validă.', 'custom-shop'));
    }

    if ($product_id > 0) {
        // Șterge produsul utilizând funcția WordPress
        $deleted = wp_delete_post($product_id, true);
        if ($deleted) {
            wp_safe_redirect(admin_url('admin.php?page=custom-shop&message=deleted'));
            exit;
        } else {
            wp_safe_redirect(admin_url('admin.php?page=custom-shop&message=error'));
            exit;
        }
    } else {
        wp_safe_redirect(admin_url('admin.php?page=custom-shop&message=invalid'));
        exit;
    }
}

custom_shop_delete_product();
