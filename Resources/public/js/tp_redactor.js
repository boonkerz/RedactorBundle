(function($) {
    // If no redactor type used, just return
    if (undefined === window.tp_redactor) {
        return;
    }

    /**
     * Transform a form field into a redactor editor.
     * Needs the id as context
     */
    var redactorize = function() {
        $('#'+this).redactor({
            imageGetJson: Routing.generate('_redactor_images'),
            imageUpload: Routing.generate('_redactor_upload'),
            shortcuts: false
        });
    };

    $(function(){
        $.each(window.tp_redactor, redactorize);
    });

}(jQuery));
