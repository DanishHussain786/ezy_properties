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
  $('.dy_unit_number, .dy_room_no, .dy_floor, .dy_rent, .dy_other_charges, .dy_dewa_ch, .dy_wifi_ch, .dy_misc_ch, .dy_prop_add, .dy_bs_level').css('display', 'none');
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

$(document).on("change", "#unit_type", function(event) {
  var val = $(this).val();
  $("#unit_no").text(val ? val + " No." : "Property No.");
});

$(document).on("change", "#prop_type", function(event) {
  if (!$('#fae-property').hasClass('action-buttons')) {
    var val = $(this).val();
    $("#property_type").text(val ? val + " No." : "Property No.");

    /*
    $('#unit_number, #unit_floor, #unit_rent').each(function() {
      if ($(this).is('select')) {
        $(this).val('').trigger("change"); // Reset select to first option
      } else {
        $(this).val(''); // Clear input field value
      }
      // $('.dy_dewa_ch, .dy_wifi_ch, .dy_misc_ch').css('display', 'none');
    });
    */
  }

  /*

  $('.dy_unit_number, .dy_room_no, .dy_floor, .dy_rent, .dy_prop_add, .dy_bs_level').css('display', 'none');

  if (val === "Villa" || val === "Appartment" || val === "Studio" || val === "Room") {
    $('.dy_unit_number, .dy_floor, .dy_rent, .dy_other_charges, .dy_prop_add').css('display', 'block');
  }
  else if (val === "Bed Space") {
    $('.dy_room_no, .dy_rent, .dy_other_charges, .dy_bs_level').css('display', 'block');
  }
  */
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

$(document).on("click", ".handle_property", function(event) {
  event.preventDefault();

  var formData = $('#fae-property').serializeArray();
  dynamicAjaxRequest(
    '/property',
    "POST",
    formData,
    function (response) {
      try {
        if (response.status == 200 || response.status == "success") {
          Swal.fire("Success!", response.message ?? `Api call is successfull.`, "success");
          $('#fae-property .action-buttons').remove(); // Close all modals, including hidden ones
          $('.prop_content').html(response.extra_data.render_html ?? ""); // Close all modals, including hidden ones

          if ($('#fae-property input[name="update_id"]').length === 0) {
            $('#fae-property').prepend(
              $('<input>', {
                type: 'hidden',
                name: 'update_id',
                value: response.data.id ?? 0
              })
            );
          } else {
            $('#fae-property input[name="update_id"]').val(response.data.id ?? 0); // Update existing value if needed
          }

          const targetValues = ["Villa", "Studio", "Room"];
          if (response.data && targetValues.includes(response.data.prop_type)) {
            $('#prop_type option[value="Building"]').remove();
          }
          else {
            $('#prop_type option[value="Villa"]').remove();
            $('#prop_type option[value="Studio"]').remove();
            $('#prop_type option[value="Room"]').remove();
          }
        }
        else {
          toastr.error(
            response.message ?? "Something went wrong during request."
          );
        }
      } catch (e) {
        console.error("Error parsing response:", e);
      }
    },
    function (xhr, status, error) {
      var response = xhr.responseJSON;
      if (response && response.validation_errors) {
        ajaxResposneValidationErrors('#fae-property', response.validation_errors);
        toastr.error(response.message ?? "Form validation errors are found.");
      }
      else {
        Swal.fire("Error!", `Something went wrong.`, "error");
      }
    }
  );
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

$(document).on("click", "#add_prop_units", function(event) {
  event.preventDefault();

  let prop_id = $('#fae-property input[name="update_id"]').val();
  if ($('.manage_prop_units input[name="property_id"]').length === 0) {
    $('.manage_prop_units').prepend(
      $('<input>', {
        type: 'hidden',
        name: 'property_id',
        value: prop_id ?? 0
      })
    );
  } else {
    $('.manage_prop_units input[name="property_id"]').val(prop_id ?? 0); // Update existing value if needed
  }

  $("#prop_units_popup").modal("show");


  // var prop_id = $(this).data("prop_id");
  // var url = $(this).data("action_url");
  // $('.update_popup').attr("action", url);

  // dynamicAjaxGetRequest('/property/'+prop_id, { 'prop_id': prop_id, 'return_to': 'model_reservation' }, function(response) {
  //   try {
  //     $(".model-ajax").html(response);
  //   } catch (e) {
  //     console.error('Error parsing response:', e);
  //   }
  // }, function(xhr, status, error) {
  //   console.error('Error:', status, error);
  // });
});

$(document).on("click", "#add_prop_units_btn", function(event) {
  event.preventDefault();

  let valid_data = true;
  var $form = $('.manage_prop_units');

  // Validate fields dynamically
  valid_data = valid_data && validateFields($form.find('.unit_type'), "The unit type field is required.");
  valid_data = valid_data && validateFields($form.find('.unit_number'), "The property no. field is required.");
  valid_data = valid_data && validateFields($form.find('.unit_floor'), "The floor no. field is required.");
  valid_data = valid_data && validateFields($form.find('.unit_rent'), "The rent field is required.");

  if (valid_data) {
    var formData = $form.serializeArray();

    dynamicAjaxRequest(
      '/property_unit',
      "POST",
      formData,
      function (response) {
        try {
          if (response.status == 200 || response.status == "success") {
            Swal.fire("Success!", response.message ?? `Api call is successfull.`, "success");

            fetchItems({
              endpoint: "/property_unit",
              method: "GET",
              data: {
                property_id: $('.manage_prop_units input[name="property_id"]').val() ?? 0,
                fetch_all: "true",
                render_view: "property.partials.prop_buildings",
              },
              render_resp_in: ".prop_content",
              // append_html: true,
            },
            function (completed, html) { // this callback will trigger on success
              if (completed) {
                resetForm($form[0]);
                $("#prop_units_popup").modal("hide");
            }});
          }
          else {
            toastr.error(
              response.message ?? "Something went wrong during request."
            );
          }
        } catch (e) {
          console.error("Error parsing response:", e);
        }
      },
      function (xhr, status, error) {
        Swal.fire("Error!", `There was an error while ordering.`, "error");
      }
    );
  }
});

$('#reservation_popup').on('shown.bs.modal', function () {
  $('.select2_field').select2();
});
