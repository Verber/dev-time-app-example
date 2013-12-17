/**
 * Created by imosiev on 17.12.13.
 */
$(function() {
    Dropzone.autoDiscover = false;

    var galleryUploader = new Dropzone('#gallery_uploader', {
        paramName: "form[file]", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        acceptedFiles: "image/*",
        addRemoveLinks: false
    });
    galleryUploader.on('sending', function(file, xhr, formData) {
        formData.append("form[album]", $('#gallery_uploader').data('album_id'));
    });
});