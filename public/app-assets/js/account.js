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

$(document).on("click", ".view_payables", function(event) {
  event.preventDefault();
  var item_id = $(this).data("item_id");
  // var url = $(this).data("action_url");
  // $('.update_popup').attr("action", url);
  dynamicAjaxGetRequest('/booking/'+item_id, { 'item_id': item_id, 'return_to': 'model_payables' }, function(response) {
    try {
      $(".model-ajax-receipts").html(response);
      $("#payables_popup").modal("show");
      // calculateTotal();
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    console.error('Error:', status, error);
  });
});

// $(document).on("click", ".update_reserv_submit", function(event) {
//   event.preventDefault();

//   let url = $('.update_popup').attr("action");
//   var data = $("#upd_reservation").serializeArray();
//   dynamicAjaxRequest(url, 'PUT', data, function(response) {
//     try {
//       toastr.success(response.message);
//       $('.update_reserv_submit').prop('disabled', true);
//       if (response.records.redirect_url) {
//         setTimeout(function() {
//           window.location.href = response.records.redirect_url; // Replace with your desired route
//         }, 2000);
//       }
//     } catch (e) {
//       console.error('Error parsing response:', e);
//     }
//   }, function(xhr, status, error) {
//     toastr.error(xhr.responseJSON.message);
//     console.error('Error:', status, error);
//   });
// });

// $(document).on("click", ".checkin_btn", function(event) {
//   event.preventDefault();
//   var data_object = extract_key_and_values($(this).data("metadata"));
//   $("#book_id").val($(this).data("item_id"));
//   $("#prop_id").val(data_object.porp);
//   $("#user_id").val(data_object.resu);
//   $(".tot_payable").val(data_object.latot);
//   $("#checkin_popup").modal("show");
// });

$(document).on("click", ".initial_deposit_btn", function(event) {
  event.preventDefault();
  $(".tot_payable").val($(this).data("total"));
  // var data_object = extract_key_and_values($(this).data("metadata"));
  // $("#book_id").val($(this).data("item_id"));
  // $("#prop_id").val(data_object.porp);
  // $("#user_id").val(data_object.resu);
  // $("#tot_payable").val(data_object.latot);
  $("#payment_popup").modal("show");
});