jQuery(document).ajaxStart(function() {
  jQuery("#spinner").show();
});
jQuery(document).ajaxStop(function() {
  jQuery("#spinner").hide();
});
