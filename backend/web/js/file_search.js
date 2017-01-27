(
    function($){
        $(document).on('change','[data-submit]',
            function(event){
                event.preventDefault();
                $(this).closest('form').trigger('submit');
            }
        );
    }
)(jQuery);

