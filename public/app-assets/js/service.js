jQuery(document).ready(function () {
  $(".searchable").select2();
  setTimeout(function () {
    $(".alert-success").hide();
    $(".alert-danger").hide();
  }, 4000);
});

$(document).on("click", "#add_service", function(event) {
  event.preventDefault();

  $("#service_popup").modal("show");
});

$(document).on("click", "#add_service_btn", function(event) {
  var $form = $('#manage-service'), formData, url, method, elements;
  let valid_data = true;

  // Validate fields dynamically
  valid_data = valid_data && validateFields($form.find('.validity_type'), "The validity type field is required.");
  valid_data = valid_data && validateFields($form.find('.type'), "The service type field is required.");
  valid_data = valid_data && validateFields($form.find('.title'), "The title field is required.");
  valid_data = valid_data && validateFields($form.find('.description'), "The description field is required.");
  valid_data = valid_data && validateFields($form.find('.amount'), "The amount field is required.");

  if (valid_data) {
    // Common form actions
    formData = $form.serializeArray(); // Serialize form data
    url = $form.attr('action');
    method = $form.attr('method');
    elements = $form[0];

    dynamicAjaxRequest(
      url,
      method,
      formData,
      function (response) {
        try {
          if (response.status == 200 || response.status == "success") {
            resetForm(elements);
            Swal.fire("Success!", response.message ?? `Api call is successfull.`, "success");
            $("#service_popup").modal("hide");
            getServiceListings();
          } else {
            toastr.error(response.message ?? "Something went wrong during request.");
          }
        } catch (e) {
          console.error("Error parsing response:", e);
        }
      },
      function (xhr, status, error) {
        var response = xhr.responseJSON; // Assuming the server returns JSON
        if (response && response.validation_errors) {
          let parent_div = null;
          if ($form.is("#manage-service"))
            parent_div = '#manage-service';

          ajaxResposneValidationErrors(parent_div, response.validation_errors);
          toastr.error(response.message ?? "Please fill valid data in form.");
        } else {
          Swal.fire("Error!", "There was an error while processing the request.", "error");
        }
      }
    );
  }
});

$(document).on("click", ".update_service_btn", function(event) {
  event.preventDefault();
  var update_id = $(this).data("item_id");
  var url = $(this).data("action_url");
  $('.update_popup').attr("action", url);

  dynamicAjaxGetRequest('/service/'+update_id, { 'update_id': update_id, 'return_to': 'model_upd_service' }, function(response) {
    try {
      $(".model-ajax").html(response);
      $("#update_service_popup").modal("show");
      calculateTotal();
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    console.error('Error:', status, error);
  });
});

$(document).on("click", ".update_service_submit", function(event) {
  event.preventDefault();

  let url = $('.update_popup').attr("action");
  var data = $("#upd_service").serializeArray();
  dynamicAjaxRequest(url, 'PUT', data, function(response) {
    try {
      $('.update_service_submit').prop('disabled', true);
      Swal.fire("Success!", response.message ?? `Api call is successfull.`, "success");
      $("#update_service_popup").modal("hide");
      getServiceListings();
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    toastr.error(xhr.responseJSON.message);
    console.error('Error:', status, error);
  });
});
