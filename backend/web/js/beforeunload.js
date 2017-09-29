(function($){

    var refresh = false;

    $( window ).on("beforeunload", function( event ) {
        if ( $( event.target.activeElement ).is("a") || refresh === true ){
            return false;
        }
        return true;
    });

    $( window ).on('keydown', function( event ){
        //F5 or Ctrl+R
        if ( event.keyCode === 116 || ( event.ctrlKey && event.keyCode === 82 ) )
        refresh = true;
    });

})(jQuery);