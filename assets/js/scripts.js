jQuery(document).ready(function($){
    $('.gallery-thumbnail').click(function(){
        var src = $(this).attr('src');
        $('.product-gallery .featured-image img').attr('src', src);
    });
});
