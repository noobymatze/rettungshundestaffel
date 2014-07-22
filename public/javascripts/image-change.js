!function(window, document) {
    'use strict';

    if(window.FileReader && window.FileList) {
        var bildPreview = document.getElementById('bildPreview');
        var fileChooser = document.getElementById('bild');
        var reader = new FileReader();
        reader.onload = function() {
            bildPreview.src = reader.result;
        };

        fileChooser.addEventListener('change', function() {
            var files = fileChooser.files;
            if(files.length > 0) {
                reader.readAsDataURL(files[0]);
            }
        });
    }

}(this, this.document);