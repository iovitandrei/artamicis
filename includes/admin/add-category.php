<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

// Handle adăugare categorie
if (isset($_POST['add_category'])) {
    global $wpdb;

    $table_name = $wpdb->prefix . 'categories';
    $name = sanitize_text_field($_POST['category_name']);
    $parent_id = intval($_POST['parent_id']);

    // Validare: Verificăm dacă numele categoriei este unic
    $exists = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM `$table_name` WHERE `name` = %s", $name));
    if ($exists) {
        echo '<div class="notice notice-error is-dismissible"><p>' . __('Categorie deja existentă.', 'custom-shop') . '</p></div>';
    } else {
        $wpdb->insert($table_name, [
            'name' => $name,
            'parent_id' => $parent_id,
        ]);

        echo '<div class="notice notice-success is-dismissible"><p>' . sprintf(__('Categorie "%s" adăugată cu succes!', 'custom-shop'), esc_html($name)) . '</p></div>';
    }
}

// Funcția pentru generarea dropdown-ului de categorii
function custom_shop_get_categories_dropdown($selected = 0, $parent_id = 0, $depth = 0) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'categories';

    $categories = $wpdb->get_results($wpdb->prepare("SELECT * FROM `$table_name` WHERE `parent_id` = %d", $parent_id), ARRAY_A);

    foreach ($categories as $category) {
        $indent = str_repeat('&nbsp;&nbsp;', $depth);
        echo '<option value="' . esc_attr($category['id']) . '"' . selected($selected, $category['id'], false) . '>' . $indent . esc_html($category['name']) . '</option>';

        // Recurență pentru subcategorii
        custom_shop_get_categories_dropdown($selected, $category['id'], $depth + 1);
    }
}
?>

<div class="wrap">
    <h1><?php _e('Adaugă Categorie', 'custom-shop'); ?></h1>
    <form method="post">
        <table class="form-table">
            <tr>
                <th><label for="category_name"><?php _e('Nume Categorie', 'custom-shop'); ?></label></th>
                <td><input name="category_name" type="text" id="category_name" value="" class="regular-text"></td>
            </tr>
            <tr>
                <th><label for="parent_id"><?php _e('Categorie Părinte', 'custom-shop'); ?></label></th>
                <td>
                    <select name="parent_id">
                        <option value="0"><?php _e('Fără Părinte', 'custom-shop'); ?></option>
                        <?php custom_shop_get_categories_dropdown(); ?>
                    </select>
                </td>
            </tr>
        </table>
        <p class="submit"><input type="submit" name="add_category" id="add_category" class="button button-primary" value="<?php _e('Adaugă Categorie', 'custom-shop'); ?>"></p>
    </form>
</div>
