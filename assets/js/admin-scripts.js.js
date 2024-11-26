jQuery(document).ready(function($){
    var mediaUploader;

    $('#upload_featured_image_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Selectează Imagine',
            button: {
                text: 'Selectează Imagine'
            },
            multiple: false
        });
        mediaUploader.on('select', function() {
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            $('#product_featured_image').val(attachment.id);
            $('#featured_image_preview').html('<img src="'+attachment.url+'" style="max-width: 100px;"/>');
        });
        mediaUploader.open();
    });

    $('#upload_gallery_images_button').click(function(e) {
        e.preventDefault();
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        mediaUploader = wp.media.frames.file_frame = wp.media({
            title: 'Selectează Imagini',
            button: {
                text: 'Selectează Imagini'
            },
            multiple: true
        });
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            var image_ids = [];
            var image_html = '';
            $.each(attachments, function(index, attachment) {
                image_ids.push(attachment.id);
                image_html += '<img src="'+attachment.url+'" style="max-width: 100px; margin-right: 10px;"/>';
            });
            $('#product_gallery_images').val(image_ids.join(','));
            $('#gallery_images_preview').html(image_html);
        });
        mediaUploader.open();
    });

    $('#add_characteristic_button').click(function(e) {
        e.preventDefault();
        $('#characteristics_container').append('<div class="characteristic"><input type="text" name="product_characteristics[]" placeholder="Denumire" class="regular-text" required><input type="text" name="product_characteristics[]" placeholder="Valoare" class="regular-text" required><button type="button" class="remove_characteristic_button button">Șterge</button></div>');
    });

    $(document).on('click', '.remove_characteristic_button', function(e) {
        e.preventDefault();
        $(this).closest('.characteristic').remove();
    });
});
