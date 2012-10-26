(function($) {
    // If no redactor type used, just return
    if (undefined === window.tp_redactor) {
        return;
    }

    /**
     * Default redactor options.
     * Values are sets at domready (for Routing dependency)
     */
    var defaultOptions = null;

    /**
     * Transform a form field into a redactor editor.
     * Needs the id as context
     */
    var redactorize = function(id) {
        $('#'+id).redactor($.extend({}, defaultOptions, this));
    };

    $(function(){
        defaultOptions = {
            imageGetJson: Routing.generate('_redactor_images'),
            imageUpload:  Routing.generate('_redactor_upload'),
            shortcuts:    false
        };
        $.each(window.tp_redactor, redactorize);
    });

}(jQuery));
