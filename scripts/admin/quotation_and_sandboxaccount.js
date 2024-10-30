jQuery("#woocommerce_kronosexpress_shipping_woocommerce_quotation").on(
  "click",
  function(e) {
    window.open(
      "/wp-admin/admin.php?page=kronosexpress_quotation_page&nonce=" +
      kronosexpress_post_object.nonce
    );
    e.preventDefault();
    return false;
  }
);
jQuery("#woocommerce_kronosexpress_shipping_woocommerce_sandboxaccount").on(
  "click",
  function(e) {
    window.open(
      "/wp-admin/admin.php?page=kronosexpress_create_sandbox_page&nonce=" +
      kronosexpress_post_object.nonce
    );
    e.preventDefault();
    return false;
  }
);
