<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function custom_shop_add_admin_menu() {
    // Adaugă meniul principal
    add_menu_page(
        __('Magazin', 'custom-shop'),
        __('Magazin', 'custom-shop'),
        'manage_options',
        'custom-shop',
        'custom_shop_view_products_page',
        'dashicons-store'
    );

    // Submeniu: Produse
    add_submenu_page(
        'custom-shop',
        __('Produse', 'custom-shop'),
        __('Produse', 'custom-shop'),
        'manage_options',
        'custom-shop',
        'custom_shop_view_products_page'
    );

    // Submeniu: Adaugă Produs
    add_submenu_page(
        'custom-shop',
        __('Adaugă Produs', 'custom-shop'),
        __('Adaugă Produs', 'custom-shop'),
        'manage_options',
        'custom-shop-add-product',
        'custom_shop_add_product_page'
    );

    // Submeniu invizibil: Editează Produs
    add_submenu_page(
        '', // Înlocuit NULL cu șir gol pentru a evita problemele
        __('Editează Produs', 'custom-shop'),
        __('Editează Produs', 'custom-shop'),
        'manage_options',
        'custom-shop-edit-product',
        'custom_shop_edit_product_page'
    );

    // Submeniu: Categorii
    add_submenu_page(
        'custom-shop',
        __('Categorii', 'custom-shop'),
        __('Categorii', 'custom-shop'),
        'manage_options',
        'custom-shop-categories',
        'custom_shop_view_categories_page'
    );

    // Submeniu: Adaugă Categorie
    add_submenu_page(
        'custom-shop',
        __('Adaugă Categorie', 'custom-shop'),
        __('Adaugă Categorie', 'custom-shop'),
        'manage_options',
        'custom-shop-add-category',
        'custom_shop_add_category_page'
    );

    // Submeniu invizibil: Editează Categorie
    add_submenu_page(
        '', // Înlocuit NULL cu șir gol
        __('Editează Categorie', 'custom-shop'),
        __('Editează Categorie', 'custom-shop'),
        'manage_options',
        'custom-shop-edit-category',
        'custom_shop_edit_category_page'
    );

    // Submeniu: Comenzi
    add_submenu_page(
        'custom-shop',
        __('Comenzi', 'custom-shop'),
        __('Comenzi', 'custom-shop'),
        'manage_options',
        'custom-shop-orders',
        'custom_shop_view_orders_page'
    );

    // Submeniu: Curieri
    add_submenu_page(
        'custom-shop',
        __('Curieri', 'custom-shop'),
        __('Curieri', 'custom-shop'),
        'manage_options',
        'custom-shop-couriers',
        'custom_shop_view_couriers_page'
    );

    // Submeniu: Adaugă Curier
    add_submenu_page(
        'custom-shop',
        __('Adaugă Curier', 'custom-shop'),
        __('Adaugă Curier', 'custom-shop'),
        'manage_options',
        'custom-shop-add-courier',
        'custom_shop_add_courier_page'
    );

    // Submeniu invizibil: Editează Curier
    add_submenu_page(
        '', // Înlocuit NULL cu șir gol
        __('Editează Curier', 'custom-shop'),
        __('Editează Curier', 'custom-shop'),
        'manage_options',
        'custom-shop-edit-courier',
        'custom_shop_edit_courier_page'
    );

    // Submeniu invizibil: Șterge Produs
    add_submenu_page(
        '', // Înlocuit NULL cu șir gol
        __('Șterge Produs', 'custom-shop'),
        __('Șterge Produs', 'custom-shop'),
        'manage_options',
        'custom-shop-delete-product',
        'custom_shop_delete_product_page'
    );
}

// Funcțiile pentru fiecare pagină
function custom_shop_view_products_page() {
    include plugin_dir_path(__FILE__) . 'view-products.php';
}

function custom_shop_add_product_page() {
    include plugin_dir_path(__FILE__) . 'add-product.php';
}

function custom_shop_edit_product_page() {
    include plugin_dir_path(__FILE__) . 'edit-product.php';
}

function custom_shop_view_categories_page() {
    include plugin_dir_path(__FILE__) . 'view-categories.php';
}

function custom_shop_add_category_page() {
    include plugin_dir_path(__FILE__) . 'add-category.php';
}

function custom_shop_edit_category_page() {
    include plugin_dir_path(__FILE__) . 'edit-category.php';
}

function custom_shop_view_orders_page() {
    include plugin_dir_path(__FILE__) . 'view-orders.php';
}

function custom_shop_view_couriers_page() {
    include plugin_dir_path(__FILE__) . 'view-couriers.php';
}

function custom_shop_add_courier_page() {
    include plugin_dir_path(__FILE__) . 'add-courier.php';
}

function custom_shop_edit_courier_page() {
    include plugin_dir_path(__FILE__) . 'edit-courier.php';
}

function custom_shop_delete_product_page() {
    include plugin_dir_path(__FILE__) . 'delete-product.php';
}

// Adăugăm meniurile în acțiunea 'admin_menu'
add_action('admin_menu', 'custom_shop_add_admin_menu');

?>
