function kronosexpress_tracking_client_key_enter(e, that) {
  if (e.keyCode === 13) {
    $this = that;
    e.preventDefault();
    request(jQuery($this).val());
  }
}
function request($awb) {
  jQuery('#tbl_tracking_kronosexpress').fadeOut().empty();
  if (typeof $awb == "undefined") {
    $awb = jQuery("#awb").val();
  }
  if ($awb) {
    jQuery
      .ajax({
        method: "POST",
        url: tracking_var.url,
        data: {
          action: "kronosexpress_tracking_action_submit",
          awb: jQuery("#awb").val(),
          nonce: tracking_var.nonce
        },
        success: function(value) {
          if (typeof(value) === 'object'){
              $str = '<table>';
              $str += '<thead>';
              $str += '<tr>';
              $str += '<td>' + tracking_var.date + '</td>';
              $str += '<td>' + tracking_var.location + '</td>';
              $str += '<td>' + tracking_var.status + '</td>';
              $str += '</tr>';
              $str += '</thead>';
              $str += '<tbody>';
              for (i = 0; i < value.length; i++) {
                $str += '<tr>';
                $str += '<td>' + value[i].DATE + '</td>';
                $str += '<td>' + value[i].SETTLEMENTID + '</td>';
                $str += '<td>' + value[i].STATUS + '</td>';
                $str += '</tr>';
              }
              $str += '</tbody>';
              $str += '</table>';
              jQuery('#tbl_tracking_kronosexpress').html($str).fadeIn();
          }
          else {
            alert(value);
          }
        },
        error: function(a, b, c) {
          alert(tracking_var.errormsg);
        }
      })
      .done(function() {});
  }
}

