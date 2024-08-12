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

$(document).on("click", ".update_reserv_submit", function(event) {
  event.preventDefault();

  let url = $('.update_popup').attr("action");
  var data = $("#upd_reservation").serializeArray();
  dynamicAjaxRequest(url, 'PUT', data, function(response) {
    try {
      toastr.success(response.message);
      $('.update_reserv_submit').prop('disabled', true);
      if (response.records.redirect_url) {
        setTimeout(function() {
          window.location.href = response.records.redirect_url; // Replace with your desired route
        }, 2000);
      }
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    toastr.error(xhr.responseJSON.message);
    console.error('Error:', status, error);
  });
});



$('#update_reservation_popup').on('shown.bs.modal', function () {
  $('.select2_field').select2();
});