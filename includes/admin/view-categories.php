<?php
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

global $wpdb;
$table_name = $wpdb->prefix . 'categories';
$categories = $wpdb->get_results("SELECT * FROM `$table_name`", ARRAY_A);
?>

<div class="wrap">
    <h1><?php _e('Categorii', 'custom-shop'); ?></h1>
    <table class="wp-list-table widefat fixed striped">
        <thead>
            <tr>
                <th><?php _e('Nume', 'custom-shop'); ?></th>
                <th><?php _e('Categorie Părinte', 'custom-shop'); ?></th>
                <th><?php _e('Acțiuni', 'custom-shop'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <tr>
                        <td><?php echo esc_html($category['name']); ?></td>
                        <td>
                            <?php
                            if ($category['parent_id'] == 0) {
                                echo __('Fără Părinte', 'custom-shop');
                            } else {
                                $parent = $wpdb->get_var($wpdb->prepare("SELECT `name` FROM `$table_name` WHERE `id` = %d", $category['parent_id']));
                                echo esc_html($parent);
                            }
                            ?>
                        </td>
                        <td>
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-edit-category&category_id=' . $category['id']); ?>" class="button"><?php _e('Editează', 'custom-shop'); ?></a>
                            <a href="<?php echo admin_url('admin.php?page=custom-shop-categories&action=delete&category_id=' . $category['id']); ?>" class="button"> <?php _e('Șterge', 'custom-shop'); ?></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="3"><?php _e('Nu există categorii.', 'custom-shop'); ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
