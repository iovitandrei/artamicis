<?php
/*
Plugin Name: Magazin online cu produse simple
Description: Plugin pentru gestionarea unui magazin online simplu.
Version: 1.1
Author: Iovita Alexandru
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Ieși dacă fișierul este accesat direct
}

// Eliminăm apelul la wp_session_start, deoarece nu este definit și generează o eroare. Vom folosi alte metode pentru a gestiona datele sesiunii.
// În cazul în care sunt necesare sesiuni, ar trebui să fie implementată o metodă compatibilă cu WordPress.

include_once 'includes/admin/menu.php';

// Înregistrarea unui Tip Personalizat de Postare pentru Produse
function custom_shop_register_post_type() {
    $labels = array(
        'name' => _x( 'Produse', 'Post Type General Name', 'custom-shop' ),
        'singular_name' => _x( 'Produs', 'Post Type Singular Name', 'custom-shop' ),
        'menu_name' => __( 'Produse', 'custom-shop' ),
        'name_admin_bar' => __( 'Produs', 'custom-shop' ),
        'archives' => __( 'Arhiva Produse', 'custom-shop' ),
        'attributes' => __( 'Atribute Produs', 'custom-shop' ),
        'parent_item_colon' => __( 'Părinte Produs:', 'custom-shop' ),
        'all_items' => __( 'Toate Produsele', 'custom-shop' ),
        'add_new_item' => __( 'Adaugă Produs Nou', 'custom-shop' ),
        'add_new' => __( 'Adaugă Nou', 'custom-shop' ),
        'new_item' => __( 'Produs Nou', 'custom-shop' ),
        'edit_item' => __( 'Editează Produs', 'custom-shop' ),
        'update_item' => __( 'Actualizează Produs', 'custom-shop' ),
        'view_item' => __( 'Vizualizează Produs', 'custom-shop' ),
        'view_items' => __( 'Vizualizează Produse', 'custom-shop' ),
        'search_items' => __( 'Caută Produs', 'custom-shop' ),
        'not_found' => __( 'Nu a fost găsit', 'custom-shop' ),
        'not_found_in_trash' => __( 'Nu a fost găsit în Coș', 'custom-shop' ),
        'featured_image' => __( 'Imagine Reprezentativă', 'custom-shop' ),
        'set_featured_image' => __( 'Setează imaginea reprezentativă', 'custom-shop' ),
        'remove_featured_image' => __( 'Șterge imaginea reprezentativă', 'custom-shop' ),
        'use_featured_image' => __( 'Folosește ca imagine reprezentativă', 'custom-shop' ),
    );
    $args = array(
        'label' => __( 'Produs', 'custom-shop' ),
        'description' => __( 'Postare pentru produse în magazin', 'custom-shop' ),
        'labels' => $labels,
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
        'hierarchical' => false,
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'exclude_from_search' => false,
        'publicly_queryable' => true,
        'capability_type' => 'post',
        'show_in_rest' => true,
    );
    register_post_type( 'product', $args );
}
add_action( 'init', 'custom_shop_register_post_type', 0 );

// Înregistrarea unei Taxonomii Personalizate pentru Categoriile de Produse
function custom_shop_register_taxonomy() {
    $labels = array(
        'name' => _x( 'Categorii Produse', 'Taxonomy General Name', 'custom-shop' ),
        'singular_name' => _x( 'Categorie Produs', 'Taxonomy Singular Name', 'custom-shop' ),
        'menu_name' => __( 'Categorii Produse', 'custom-shop' ),
        'all_items' => __( 'Toate Categoriile', 'custom-shop' ),
        'parent_item' => __( 'Categorie Părinte', 'custom-shop' ),
        'parent_item_colon' => __( 'Categorie Părinte:', 'custom-shop' ),
        'new_item_name' => __( 'Nume Categorie Nouă', 'custom-shop' ),
        'add_new_item' => __( 'Adaugă Categorie Nouă', 'custom-shop' ),
        'edit_item' => __( 'Editează Categorie', 'custom-shop' ),
        'update_item' => __( 'Actualizează Categorie', 'custom-shop' ),
        'view_item' => __( 'Vizualizează Categorie', 'custom-shop' ),
        'separate_items_with_commas' => __( 'Separă categoriile prin virgulă', 'custom-shop' ),
        'add_or_remove_items' => __( 'Adaugă sau șterge categorii', 'custom-shop' ),
        'choose_from_most_used' => __( 'Alege dintre cele mai folosite categorii', 'custom-shop' ),
        'popular_items' => __( 'Categorii Populare', 'custom-shop' ),
        'search_items' => __( 'Caută Categorii', 'custom-shop' ),
        'not_found' => __( 'Nu a fost găsit', 'custom-shop' ),
        'no_terms' => __( 'Nu există categorii', 'custom-shop' ),
        'items_list' => __( 'Listă categorii', 'custom-shop' ),
        'items_list_navigation' => __( 'Navigare listă categorii', 'custom-shop' ),
    );
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'public' => true,
        'show_ui' => true,
        'show_admin_column' => true,
        'show_in_nav_menus' => true,
        'show_tagcloud' => true,
        'show_in_rest' => true,
    );
    register_taxonomy( 'product_cat', array( 'product' ), $args );
}
add_action( 'init', 'custom_shop_register_taxonomy', 0 );

// Înregistrează Scripturi și Stiluri
function custom_shop_enqueue_scripts($hook) {
    if ( strpos($hook, 'custom-shop') === false ) {
        return;
    }
    wp_enqueue_media();
    wp_enqueue_script( 'custom-shop-admin-script', plugin_dir_url(__FILE__) . 'assets/js/admin.js', array('jquery'), null, true );
}
add_action( 'admin_enqueue_scripts', 'custom_shop_enqueue_scripts' );

?>
