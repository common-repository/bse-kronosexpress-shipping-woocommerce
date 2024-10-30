function kronosexpress_load_points() {
  jQuery("input[value='kronosexpress_shipping_pexpress']").bind(
    "click",
    function () {
      jQuery("#kronosexpress-shipping-points").fadeIn();
    }
  );
  if (
    jQuery("input[value='kronosexpress_shipping_pexpress']").prop("checked")
  ) {
    jQuery("#kronosexpress-shipping-points").fadeIn();
  }
  jQuery("input[value='kronosexpress_shipping_peconomy']").bind(
    "click",
    function () {
      jQuery("#kronosexpress-shipping-points").fadeIn();
    }
  );
  if (
    jQuery("input[value='kronosexpress_shipping_peconomy']").prop("checked")
  ) {
    jQuery("#kronosexpress-shipping-points").fadeIn();
  }
  if (
    jQuery("#shipping_method > li").length === 1 &&
    (jQuery("#shipping_method > li > input").val() ==
      "kronosexpress_shipping_pexpress" ||
      jQuery("#shipping_method > li > input").val() ==
        "kronosexpress_shipping_peconomy")
  ) {
    jQuery("#kronosexpress-shipping-points").fadeIn();
  }
}
jQuery(document).ajaxComplete(function (event, xhr, settings) {
  if (settings.url.indexOf("/?wc-ajax=update_order_review") >= 0) {
    kronosexpress_load_points();
  }
});
