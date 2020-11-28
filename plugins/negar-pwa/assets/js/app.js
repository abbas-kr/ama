jQuery( function( $ ) {

    $('#pwa-generator-btn').click(function () {

        var url = $('#avn_negar-favicon img').attr('src')

        var formData = {
            'action' : 'avn_favicon_generator',
            'url' : url
        }

        $.ajax({
            url : avn.ajaxurl,
            type: "POST",
            data : formData,

            beforeSend:function(){
                $('#pwa-generator-btn').html('<span class="spinner is-active" style="display: block;margin: 0 auto;float: unset;opacity: 1;"></span>')
            },

            success:function() {
                $('#pwa-generator-btn').html('آیکون ها با موفقیت ساخته شد.')
            },
            error:function() {
                $('#pwa-generator-btn').html('خطا !!! لطفا تنظیمات را ذخیره کنید و صفحه را رفرش کنید و مجدد تست کنید.')
            },

        })

    })

    $(window).on('load', function() {
        $('.page-builder').on('click', function () {
            $('#redux_save').trigger('click')
            setTimeout(function() {
                location.reload();
            }, 5000);
        });
    });

});
