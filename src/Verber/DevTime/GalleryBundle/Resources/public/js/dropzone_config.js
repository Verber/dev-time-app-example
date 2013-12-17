/**
 * Created by imosiev on 17.12.13.
 */
Dropzone.options.galleryUploader = {
    url: uploadUrl,
    paramName: "form[file]", // The name that will be used to transfer the file
    maxFilesize: 2, // MB
    acceptedFiles: "image/*",
    addRemoveLinks: false
};