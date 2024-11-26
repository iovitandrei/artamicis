<?php
function custom_shop_delete_category() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Regret, nu ai voie să accesezi această pagină.'));
    }

    global $wpdb;

    // Preluare ID categorie din URL
    $category_id = isset($_GET['category_id']) ? intval($_GET['category_id']) : 0;

    // Ștergere categorie din baza de date
    $deleted = $wpdb->delete(
        "{$wpdb->prefix}categories",
        ['id' => $category_id]
    );

    if ($deleted) {
        echo '<div class="notice notice-success is-dismissible"><p>Categorie ștearsă cu succes!</p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>Eroare la ștergerea categoriei!</p><p>' . $wpdb->last_error . '</p></div>';
    }

    echo '<a href="' . admin_url('admin.php?page=view-categories') . '">Înapoi la lista de categorii</a>';
}
