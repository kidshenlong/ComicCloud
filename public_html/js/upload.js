/**
 * Created by Michael on 23/03/2014.
 */
$(document).ready(function(){
    droptest = Dropzone.options.dropzone = {
        paramName: "file", // The name that will be used to transfer the file
        acceptedFiles: ".cbz,.cbr,.CBZ,.CBR",
        init: function() {
            myDropZone = this;
            this.on("success", function(file, response) {

            });
            this.on("addedfile", function(file) {

            });

            this.on("complete", function(file) {

            });
        }
    };
});
