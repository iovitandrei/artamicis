<?php
function custom_shop_delete_courier() {
    if (!current_user_can('manage_options')) {
        wp_die(__('Regret, nu ai voie să accesezi această pagină.'));
    }

    global $wpdb;

    // Preluare ID curier din URL
    $courier_id = isset($_GET['courier_id']) ? intval($_GET['courier_id']) : 0;

    // Ștergere curier din baza de date
    $deleted = $wpdb->delete(
        "{$wpdb->prefix}couriers",
        ['id' => $courier_id]
    );

    if ($deleted) {
        echo '<div class="notice notice-success is-dismissible"><p>Curier șters cu succes!</p></div>';
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>Eroare la ștergerea curierului!</p><p>' . $wpdb->last_error . '</p></div>';
    }

    echo '<a href="' . admin_url('admin.php?page=view-couriers') . '">Înapoi la lista de curieri</a>';
}
