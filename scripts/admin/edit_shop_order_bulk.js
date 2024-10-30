jQuery(document).ready(function ($) {
  if ($(".kronosexpresscolumn").length > 0) {
    $(".kronosexpresscolumn").on("click", function () {
      event.stopPropagation();
    });
  }
  $("#doaction, #doaction2").click(function (event) {
    if (
      jQuery("#bulk-action-selector-top").val() == "kronosexpress_bulk_print" ||
      jQuery("#bulk-action-selector-top").val() ==
        "kronosexpress_bulk_print_express" ||
      jQuery("#bulk-action-selector-top").val() ==
        "kronosexpress_bulk_print_economy" ||
      jQuery("#bulk-action-selector-bottom").val() ==
        "kronosexpress_bulk_print" ||
      jQuery("#bulk-action-selector-bottom").val() ==
        "kronosexpress_bulk_print_express" ||
      jQuery("#bulk-action-selector-bottom").val() ==
        "kronosexpress_bulk_print_economy"
    ) {
      event.preventDefault();
      var checked = [];
      $("tbody th.check-column input[type='checkbox']:checked").each(
        function () {
          checked.push($(this).val());
        }
      );
      if (!checked.length) {
        alert("You have to select order(s) first!");
        return;
      }
      var order_ids = checked.join(",");
      if (
        jQuery("#bulk-action-selector-top").val() ==
          "kronosexpress_bulk_print" ||
        jQuery("#bulk-action-selector-bottom").val() ==
          "kronosexpress_bulk_print"
      ) {
        url =
          kronosexpress_ajax_object.create_url +
          order_ids +
          "&nonce=" +
          kronosexpress_ajax_object.nonce;
      } else if (
        jQuery("#bulk-action-selector-top").val() ==
          "kronosexpress_bulk_print_express" ||
        jQuery("#bulk-action-selector-bottom").val() ==
          "kronosexpress_bulk_print_express"
      ) {
        url =
          kronosexpress_ajax_object.create_url +
          order_ids +
          "&nonce=" +
          kronosexpress_ajax_object.nonce +
          "&method=kronosexpress_shipping_dexpress";
      } else if (
        jQuery("#bulk-action-selector-top").val() ==
          "kronosexpress_bulk_print_economy" ||
        jQuery("#bulk-action-selector-bottom").val() ==
          "kronosexpress_bulk_print_economy"
      ) {
        url =
          kronosexpress_ajax_object.create_url +
          order_ids +
          "&nonce=" +
          kronosexpress_ajax_object.nonce +
          "&method=kronosexpress_shipping_deconomy";
      }
      window.open(url, "_blank");
    }
    if (
      jQuery("#bulk-action-selector-top").val() ==
        "kronosexpress_bulk_cancel" ||
      jQuery("#bulk-action-selector-bottom").val() ==
        "kronosexpress_bulk_cancel"
    ) {
      event.preventDefault();
      var checked = [];
      $("tbody th.check-column input[type='checkbox']:checked").each(
        function () {
          checked.push($(this).val());
        }
      );
      if (!checked.length) {
        alert("You have to select order(s) first!");
        return;
      }
      var order_ids = checked.join(",");
      url =
        kronosexpress_ajax_object.cancel_url +
        order_ids +
        "&nonce=" +
        kronosexpress_ajax_object.nonce;
      window.open(url, "_blank");
    }
  });
});
function kronosexpress_open_tab(that, url) {
  if (jQuery(that).parent().find("#kronosexpress_ar").is(":checked") === true) {
    url = url + "&ar=true";
  }
  window.open(url);
  return false;
}