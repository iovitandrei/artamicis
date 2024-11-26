<?php
// File: edit-category.php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

if (isset($_GET['category_id'])) {
    $category_id = intval($_GET['category_id']);

    global $wpdb;
    $table_name = $wpdb->prefix . 'categories';
    $category = $wpdb->get_row($wpdb->prepare("SELECT * FROM `$table_name` WHERE `id` = %d", $category_id), ARRAY_A);

    if ($category) {
        if (isset($_POST['edit_category'])) {
            $name = sanitize_text_field($_POST['category_name']);
            $parent_id = intval($_POST['parent_id']);

            // Actualizare categorie
            $wpdb->update($table_name, [
                'name' => $name,
                'parent_id' => $parent_id,
            ], ['id' => $category_id]);

            echo '<div class="notice notice-success is-dismissible"><p>' . __('Categorie actualizată cu succes!', 'custom-shop') . '</p></div>';
        }
        ?>

        <div class="wrap">
            <h1><?php _e('Editează Categorie', 'custom-shop'); ?></h1>
            <form method="post">
                <table class="form-table">
                    <tr>
                        <th><label for="category_name"><?php _e('Nume Categorie', 'custom-shop'); ?></label></th>
                        <td><input name="category_name" type="text" id="category_name" value="<?php echo esc_attr($category['name']); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th><label for="parent_id"><?php _e('Categorie Părinte', 'custom-shop'); ?></label></th>
                        <td>
                            <select name="parent_id">
                                <option value="0"><?php _e('Fără Părinte', 'custom-shop'); ?></option>
                                <?php custom_shop_get_categories_dropdown($category['parent_id']); ?>
                            </select>
                        </td>
                    </tr>
                </table>
                <p class="submit"><input type="submit" name="edit_category" id="edit_category" class="button button-primary" value="<?php _e('Actualizează Categorie', 'custom-shop'); ?>"></p>
            </form>
        </div>
        <?php
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>' . __('Categorie nu a fost găsită.', 'custom-shop') . '</p></div>';
    }
}
?>
