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
  $('.dy_prop_number, .dy_room_no, .dy_floor, .dy_rent, .dy_other_charges, .dy_dewa_ch, .dy_wifi_ch, .dy_misc_ch, .dy_prop_add, .dy_bs_level').css('display', 'none');
});

$(document).on("click", "#add_res_btn", function(event) {
  event.preventDefault();
  var data = $("#create_reservation").serializeArray();
  dynamicAjaxRequest('/booking', 'POST', data, function(response) {
    try {
      toastr.success(response.message);
      $('#add_res_btn').prop('disabled', true);
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
  
$(document).on("change", "#prop_type", function(event) { 
  // Clear values of form fields
  $('#prop_number, #room_no, #prop_floor, #prop_rent, #other_charges, #dewa_ch, #wifi_ch, #misc_ch, #prop_address, #bs_level').each(function() {
    if ($(this).is('select')) {
      $(this).val('').trigger("change"); // Reset select to first option
    } else {
      $(this).val(''); // Clear input field value
    }
    $('.dy_dewa_ch, .dy_wifi_ch, .dy_misc_ch').css('display', 'none');
  });

  $('.dy_prop_number, .dy_room_no, .dy_floor, .dy_rent, .dy_prop_add, .dy_bs_level').css('display', 'none');

  var val = $(this).val();
  $("#property_type").text(val ? val + " No." : "Property No.");  


  if (val === "Villa" || val === "Appartment" || val === "Studio" || val === "Room") {
    $('.dy_prop_number, .dy_floor, .dy_rent, .dy_other_charges, .dy_prop_add').css('display', 'block');
  }
  else if (val === "Bed Space") {
    $('.dy_room_no, .dy_rent, .dy_other_charges, .dy_bs_level').css('display', 'block');
  }
});

$(document).on("change", "#other_charges", function(event) { 
  if ($(this).val() == 'Yes') {
    $('.dy_dewa_ch, .dy_wifi_ch, .dy_misc_ch').css('display', 'block');
  }
  if ($(this).val() == 'No' || $(this).val() == "") {
    $('#dewa_ch, #wifi_ch, #misc_ch').each(function() {
      $(this).val('');
    });
    $('.dy_dewa_ch, .dy_wifi_ch, .dy_misc_ch').css('display', 'none');
  }
});

$(document).on("click", "#property_btn", function(event) {
  $('.is-required').each(function() {
    if ($(this).css('display') === 'none') {
      $(this).find('input, select').prop('required', false);
    }
  });
});

$(document).on("click", ".update_property_btn", function(event) {
  event.preventDefault();
  var update_id = $(this).data("prop_id");
  var url = $(this).data("action_url");
  $('.update_popup').attr("action", url);

  dynamicAjaxGetRequest('/property/'+update_id+'/edit', { 'update_id': update_id, 'return_to': 'model_update_prop' }, function(response) {
    try {
      $(".model-ajax").html(response);
      $("#update_property_popup").modal("show");
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    console.error('Error:', status, error);
  });
});

$(document).on("click", ".reservation_btn", function(event) {
  event.preventDefault();
  var prop_id = $(this).data("prop_id");
  var url = $(this).data("action_url");
  $('.update_popup').attr("action", url);

  dynamicAjaxGetRequest('/property/'+prop_id, { 'prop_id': prop_id, 'return_to': 'model_reservation' }, function(response) {
    try {
      $(".model-ajax").html(response);
      $("#reservation_popup").modal("show");
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    console.error('Error:', status, error);
  });
});

$('#reservation_popup').on('shown.bs.modal', function () {
  $('.select2_field').select2();
});