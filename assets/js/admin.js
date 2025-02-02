(function($) {
    // we create a copy of the WP inline edit post function
    var $wp_inline_edit = inlineEditPost.edit;
 
    // and then we overwrite the function with our own code
    inlineEditPost.edit = function( id ) {
 
        // "call" the original WP edit function
        // we don't want to leave WordPress hanging
        $wp_inline_edit.apply( this, arguments );
 
        // get the post ID
        var $post_id = 0;
        if ( typeof( id ) == 'object' ) {
            $post_id = parseInt( this.getId( id ) );
        }
 
        if ( $post_id > 0 ) {
            jQuery.post(Retrilhar.ajaxUrl, {
                    action: 'retrilhar_quick_produtos',
                    post_id: $post_id, 
                    modo: "ajaxget" 
                },
                function (data) {
                    if (!data || 0 == data) {
                        return;
                    }
                    var pathElement = '#edit-' + $post_id + ' .retrilhar_id_produto'
                    jQuery(pathElement).val(data.data.idProduto)
                }
            )
        }
    };
 
})(jQuery);
