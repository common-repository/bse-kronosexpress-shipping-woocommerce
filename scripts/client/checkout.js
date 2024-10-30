jQuery( 'form.checkout' ).on( 'change', 'input[name^="payment_method"]', function() { 
    jQuery('body').trigger('update_checkout');
});