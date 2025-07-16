$(window).on("load", function () {
  // if (feather) {
  //   feather.replace({
  //     width: 14,
  //     height: 14,
  //   });
  // }
});

jQuery(document).ready(function () {
  $(".skin-minimal .i-check input").iCheck({
    checkboxClass: "icheckbox_minimal",
    radioClass: "iradio_minimal",
    increaseArea: "20%",
  });

  $(".skin-square .i-check input").iCheck({
    checkboxClass: "icheckbox_square-green",
    radioClass: "iradio_square-green",
  });

  $(".skin-flat .i-check input").iCheck({
    checkboxClass: "icheckbox_flat-red",
    radioClass: "iradio_flat-red",
  });

  $(".skin-line .i-check input").each(function () {
    var self = $(this),
      label = self.next(),
      label_text = label.text();

    label.remove();
    self.iCheck({
      checkboxClass: "icheckbox_line-blue",
      radioClass: "iradio_line-blue",
      insert: '<div class="icheck_line-icon"></div>' + label_text,
    });
  });

  var currentStep = 0;
  var steps = $(".step-form");
  var indicators = $(".step-indicators .step");

  $(".next-btn").on("click", function () {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  $(".prev-btn").on("click", function () {
    if (currentStep > 0) {
      currentStep--;
      showStep(currentStep);
    }
  });

  function showStep(step) {
    steps.removeClass("active").eq(step).addClass("active");
    indicators.removeClass("active").removeClass("completed");
    indicators.slice(0, step).addClass("completed");
    indicators.eq(step).addClass("active");
  }

  $("#multiStepForm").on("submit", function (event) {
    event.preventDefault();
    alert("Form submitted!");
    // Handle form submission here
  });
});

function showModal(src) {
  const modal = document.getElementById("imageModal");
  const back_content = document.getElementById("header_div");
  const modalImg = document.getElementById("imageModalContent");
  modal.style.display = "block";
  back_content.style.display = "none";
  modalImg.src = src;

  const closeModal = document.getElementById("closeModal");
  closeModal.onclick = function () {
    modal.style.display = "none";
    back_content.style.display = "block";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      back_content.style.display = "block";
    }
  };
}

$(document).on("click", ".pagination_links .pagination a", function (event) {
  event.preventDefault();
  var page = $(this).attr("href").split("page=")[1];
  $("#filterPage").val(page);
  getAjaxData();
});

$(document).on(
  "change",
  ".formFilter",
  throttle(function (event) {
    event.preventDefault();
    $("#filterPage").val(1);
    getAjaxData();
  }, 200)
);

$(document).on(
  "keyup",
  ".formFilter",
  throttle(function (event) {
    event.preventDefault();
    $("#filterPage").val(1);
    getAjaxData();
  }, 800)
);

$(document).on("click", ".formReset", function (event) {
  event.preventDefault();
  clearFormFields();
  $("#filterPage").val(1);
  getAjaxData();
});

$(document).on("click", ".delete_btn", function (event) {
  var url = $(this).data("delete_url");
  $(".delete_popup").attr("action", url);
});

var prevKey, prevControl;
$(document).on("keydown", ".only_numbers", function (event) {
  // Allow special keys: backspace, tab, delete, home, end, arrow keys, ctrl+a
  if (
    event.keyCode == 8 || // backspace
    event.keyCode == 9 || // tab
    event.keyCode == 46 || // delete
    (event.keyCode >= 35 && event.keyCode <= 40) || // arrow keys/home/end
    (event.keyCode >= 48 && event.keyCode <= 57) || // numbers on keyboard
    (event.keyCode >= 96 && event.keyCode <= 105) || // numbers on keypad
    (event.keyCode == 65 &&
      prevKey == 17 &&
      prevControl == event.currentTarget.id) || // ctrl + a, on same control
    (event.keyCode == 110 && !$(this).val().includes(".")) || // decimal point on keypad (only if not already present)
    (event.keyCode == 190 && !$(this).val().includes(".")) // decimal point on keyboard (only if not already present)
  ) {
    // If valid key, update prevKey and prevControl
    prevKey = event.keyCode;
    prevControl = event.currentTarget.id;
  } else {
    // Prevent invalid input
    event.preventDefault();
  }
});

// $(document).on("change", "#stay_months", function(event) {
//   let value = $(this).val();
//   $('#stay_months').val(value);
//   if (value !== '' && value !== 'days') {
//     calculateTotal();
//   }
//   else if (value === 'days') {
//     calculateTotal();
//   }
// });

// $(document).on("change", "#other_charges", function(event) {
//   if ($(this).val() === 'Yes') {
//     $('.hidden_charges').removeClass('d-none');
//   } else {
//     $('.hidden_charges').addClass('d-none');
//     // $("input[name='dewa_ch']").val('');
//     // $("input[name='wifi_ch']").val('');
//     $("input[name='admin_ch']").val('');
//     $("input[name='sec_ch']").val('');
//     calculateTotal();
//   }
// });

// $(document).on("change", "#deposit_by", function(event) {
//   if ($(this).val() === 'Other') {
//     $('.depositor_data').removeClass('d-none');
//   } else {
//     $('.depositor_data').addClass('d-none');
//     $("input[name='dep_name']").val('');
//     $("input[name='dep_email']").val('');
//     $("input[name='dep_contact']").val('');
//   }
// });

// $(document).on("input", "input[name='admin_ch']", function(event) {
//   $("input[name='admin_ch']").val($(this).val());
//   calculateTotal();
// });

// $(document).on("input", "input[name='sec_ch']", function(event) {
//   $("input[name='sec_ch']").val($(this).val());
//   calculateTotal();
// });

$(document).on("input", "input[name='markup_rent']", function (event) {
  $("input[name='markup_rent']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='checkin_date']", function (event) {
  $("input[name='checkin_date']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='checkout_date']", function (event) {
  $("input[name='checkout_date']").val($(this).val());
  calculateTotal();
});

function calculateExpectedRent() {
  var in_date = $('input[name="checkin_date"]').val();
  var out_date = $('input[name="checkout_date"]').val();
  var rent = parseFloat($('input[name="prop_rent"]').val()) || 0;
  var markup_rent = parseFloat($('input[name="markup_rent"]').val()) || 0;

  if (in_date && out_date) {
    diff_days = calc_datetime_difference(in_date, out_date).days;

    if (diff_days <= 0) {
      $('input[name="checkout_date"]').val("");
      $('input[name="expected_rent"]').val(0);
    } else {
      exp_rent = parseFloat((rent / 30) * diff_days);
      exp_rent = Math.round(exp_rent + markup_rent, 2);
      $('input[name="expected_rent"]').val(exp_rent);
    }
  }
}

function calculateTotal() {
  calculateExpectedRent();
  var expected_rent = parseFloat($('input[name="expected_rent"]').val()) || 0;
  var admin = parseFloat($('input[name="admin_ch"]').val()) || 0;
  var security = parseFloat($('input[name="sec_ch"]').val()) || 0;

  var total = expected_rent + admin + security;
  total = Math.ceil(total / 10) * 10;
  $('input[name="net_total"]').val(total);
}

// delay ajax request call on keypress, keyup, keydown, change event etc.
function throttle(f, delay) {
  var timer = null;
  return function () {
    var context = this,
      args = arguments;
    clearTimeout(timer);
    timer = window.setTimeout(function () {
      f.apply(context, args);
    }, delay || 800);
  };
}

function extract_key_and_values(metadata = "") {
  // Check if metadata is retrieved successfully
  if (metadata) {
    // Remove any unwanted characters (e.g., '@')
    metadata = metadata.replace("@", "");

    // Split the string by commas to get key-value pairs
    var pairs = metadata.split(",");

    // Initialize an object to hold the extracted key-value pairs
    var result = {};

    // Loop through each pair
    $.each(pairs, function (index, pair) {
      // Split each pair by '=' to separate keys and values
      var parts = pair.split("=");
      if (parts.length === 2) {
        var key = parts[0].trim();
        var value = parts[1].trim();

        // Convert value to a number (if necessary) and store it in the result object
        result[key] = parseFloat(value);
      }
    });

    // Output the result object to the console
    // console.log(result);
    return result;
  }
}

function clearFormFields() {
  // var route = $(".route_name").val();
  // if (route === "user") {
  $("#search_query").val("");
  $("#user_status").val("").trigger("change");

  // $("#select2-category").select2("val", "");
  // $("#select2-category").val("").trigger("change");
  // $("#title").val("");
  // $("#select2-orderBy_name").select2("val", "");
  // $("#select2-orderBy_name").val("").trigger("change");
  // $("#select2-orderBy_value").select2("val", "");
  // $("#select2-orderBy_value").val("").trigger("change");
  // }
  // else if (route === 'other') {
  // other routes here
  // }
}

function getAjaxData(data) {
  $(".loaderOverlay").fadeIn();
  jQuery.ajax({
    url: $("#filterForm").attr("action"),
    data: $("#filterForm").serializeArray(),
    method: $("#filterForm").attr("method"),
    dataType: "html",
    success: function (response) {
      $(".loaderOverlay").fadeOut();
      $("#table_data").html(response);
    },
  });
}

/**
 * Function to make a dynamic AJAX GET request
 * @param {string} url - The URL to which the request is sent
 * @param {object} data - Data to be sent to the server
 * @param {function} successCallback - A function to be called if the request succeeds
 * @param {function} errorCallback - A function to be called if the request fails
 */
function dynamicAjaxGetRequest(
  url,
  data,
  successCallback,
  errorCallback,
  extraParam
) {
  $.ajax({
    url: url,
    type: "GET",
    data: data,
    // dataType: 'json',
    success: function (response) {
      if (typeof successCallback === "function") {
        successCallback(response, extraParam);
      }
    },
    error: function (xhr, status, error) {
      if (typeof errorCallback === "function") {
        errorCallback(xhr, status, error);
      }
    },
  });
}

/**
 * Function to make a dynamic AJAX POST request
 * @param {string} url - The URL to which the request is sent
 * @param {object} data - Data to be sent to the server
 * @param {function} successCallback - A function to be called if the request succeeds
 * @param {function} errorCallback - A function to be called if the request fails
 */
function dynamicAjaxRequest(
  url,
  method,
  data,
  successCallback,
  errorCallback,
  extraParam
) {
  $.ajax({
    url: url,
    type: method,
    data: data,
    dataType: "json",
    beforeSend: function (xhr) {
      // If the method is POST, add CSRF token to the headers
      if (method === "POST" || method === "PUT" || method === "DELETE") {
        // Get CSRF token from the meta tag or a JavaScript variable
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        xhr.setRequestHeader("X-CSRF-TOKEN", csrfToken); // Set the CSRF token in the header
      }
    },
    success: function (response) {
      if (typeof successCallback === "function") {
        successCallback(response, extraParam);
      }
    },
    error: function (xhr, status, error) {
      if (typeof errorCallback === "function") {
        errorCallback(xhr, status, error);
      }
    },
  });
}

// Function to display validation errors in the form
function ajaxResposneValidationErrors(parent_form, errors) {
  // Loop through the validation errors
  $.each(errors, function (field, messages) {
    // Find the form input for the field

    if (
      parent_form === null ||
      parent_form == "" ||
      parent_form === undefined
    ) {
      var inputElement = $("#" + field);
      var errorSpan = inputElement
        .closest(".form-group")
        .find(".invalid-feedback");
    } else {
      var inputElement = $(parent_form).find("#" + field);
      var errorSpan = $(parent_form)
        .find("#" + field)
        .closest(".form-group")
        .find(".invalid-feedback");
    }

    // If error span exists, display the error messages
    if (errorSpan.length) {
      // Join multiple error messages, if any
      errorSpan.text(messages.join(" "));

      // Remove the 'd-none' class to make the error message visible
      errorSpan.removeClass("d-none");
    }

    // Optionally, add a class to the form input for highlighting invalid fields (for styling purposes)
    inputElement.addClass("is-invalid");
  });
}

function validateFields(field_id, error_message) {
  let field_value = $(field_id).val();
  let feedback_elem = $(field_id).closest('.form-group').find('.invalid-feedback');

  if (field_value == "" || field_value == null) {
    $(field_id).addClass('is-invalid');
    feedback_elem.text(error_message);
    feedback_elem.removeClass("d-none");
    return false;  // Invalid data
  } else {
    $(field_id).removeClass('is-invalid');
    feedback_elem.text("");
    feedback_elem.addClass("d-none");
    return true;  // Valid data
  }
}

function resetForm(form_elem = {}) {
  form_elem.reset();
  $(".searchable").select2();
}

// Reset validation errors on input change
$('input, select').on('input change', function() {
  var input = $(this);
  var errorSpan = input.closest('.form-group').find('.invalid-feedback');
  errorSpan.addClass('d-none'); // Hide error message
  input.removeClass('is-invalid'); // Remove the invalid class
});

function calc_datetime_difference(start, end) {
  // Parse the date strings into Date objects
  const startDate = new Date(start);
  const endDate = new Date(end);

  // Ensure the dates are valid
  if (isNaN(startDate.getTime()) || isNaN(endDate.getTime())) {
    throw new Error("Invalid date format");
  }

  // Calculate the difference in milliseconds
  const differenceInMillis = endDate - startDate;

  // Convert milliseconds to days, hours, minutes, seconds
  const millisPerSecond = 1000;
  const millisPerMinute = millisPerSecond * 60;
  const millisPerHour = millisPerMinute * 60;
  const millisPerDay = millisPerHour * 24;

  const dd = Math.floor(differenceInMillis / millisPerDay);
  const hh = Math.floor((differenceInMillis % millisPerDay) / millisPerHour);
  const mm = Math.floor((differenceInMillis % millisPerHour) / millisPerMinute);
  const ss = Math.floor(
    (differenceInMillis % millisPerMinute) / millisPerSecond
  );

  return {
    days: dd,
    hours: hh,
    minutes: mm,
    seconds: ss,
    difference: hh + ":" + mm + ":" + ss,
  };
}
