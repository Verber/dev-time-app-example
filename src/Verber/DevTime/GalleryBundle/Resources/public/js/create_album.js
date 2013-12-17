/**
 * Created by imosiev on 17.12.13.
 */
$(document).ready(function () {
    $('#uploader').hide();
    $('#album_link').hide();
    $('#create_album').submit(function () {
        var albumName = $('#form_name').val();
        var csrf = $('#form__token').val();
        $.post(
            $('#create_album').attr('action'),
            {
                'form[_token]': csrf,
                'form[name]': albumName,
                'form[create]': 'Create'
            },
            function(data) {
                if (data.success) {
                    $('#gallery_uploader').data('album_id', data.id);
                    $('#form_name').attr('readonly', 'readonly');
                    $('#form_create').attr('disabled', 'disabled');
                    $('#uploader').show();
                    $('#album_link').show();
                    $('#album_link a').attr('href', $('#album_link a').attr('href') + '/' + data.id);
                }
            },
            'json'
        );
        return false;
    });
});
