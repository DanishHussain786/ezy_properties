$(window).on("load", function() {
  // if (feather) {
  //   feather.replace({
  //     width: 14,
  //     height: 14,
  //   });
  // }
});

jQuery(document).ready(function() {
  setTimeout(function() {
    $(".alert-success").hide();
  }, 4000);

  $('.select2_field').select2();
});

$(document).on("click", ".update_reservation_btn", function(event) {
  event.preventDefault();
  var update_id = $(this).data("item_id");
  var url = $(this).data("action_url");
  $('.update_popup').attr("action", url);

  dynamicAjaxGetRequest('/booking/'+update_id+'/edit', { 'update_id': update_id, 'return_to': 'model_upd_reservation' }, function(response) {
    try {
      $(".model-ajax").html(response);
      $("#update_reservation_popup").modal("show");
      calculateTotal();
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    console.error('Error:', status, error);
  });
});

$('#update_reservation_popup').on('shown.bs.modal', function () {
  $('.select2_field').select2();
});