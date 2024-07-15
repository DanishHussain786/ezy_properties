$(window).on("load", function() {
  // if (feather) {
  //   feather.replace({
  //     width: 14,
  //     height: 14,
  //   });
  // }
});

jQuery(document).ready(function() {
  $('.skin-minimal .i-check input').iCheck({
    checkboxClass: 'icheckbox_minimal',
    radioClass: 'iradio_minimal',
    increaseArea: '20%'
  });

  $('.skin-square .i-check input').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green'
  });


  $('.skin-flat .i-check input').iCheck({
    checkboxClass: 'icheckbox_flat-red',
    radioClass: 'iradio_flat-red'
  });

  $('.skin-line .i-check input').each(function () {
    var self = $(this),
      label = self.next(),
      label_text = label.text();

    label.remove();
    self.iCheck({
      checkboxClass: 'icheckbox_line-blue',
      radioClass: 'iradio_line-blue',
      insert: '<div class="icheck_line-icon"></div>' + label_text
    })
  })

  var currentStep = 0;
  var steps = $(".step-form");
  var indicators = $(".step-indicators .step");

  $(".next-btn").on("click", function() {
    if (currentStep < steps.length - 1) {
      currentStep++;
      showStep(currentStep);
    }
  });

  $(".prev-btn").on("click", function() {
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

  $("#multiStepForm").on("submit", function(event) {
    event.preventDefault();
    alert("Form submitted!");
    // Handle form submission here
  });
});

function showModal(src) {
  const modal = document.getElementById('imageModal');
  const back_content = document.getElementById('header_div');
  const modalImg = document.getElementById('imageModalContent');
  modal.style.display = 'block';
  back_content.style.display = 'none';
  modalImg.src = src;

  const closeModal = document.getElementById('closeModal');
  closeModal.onclick = function() {
    modal.style.display = 'none';
    back_content.style.display = 'block';
  }

  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = 'none';
      back_content.style.display = 'block';
    }
  }
}

$(document).on("click", ".pagination_links .pagination a",
  function(event) {
    event.preventDefault();
    var page = $(this).attr("href").split("page=")[1];
    $("#filterPage").val(page);
    getAjaxData();
  }
);

$(document).on("change", ".formFilter", throttle(function(event) {
    event.preventDefault();
    $("#filterPage").val(1);
    getAjaxData();
  }, 200)
);

$(document).on("keyup", ".formFilter", throttle(function(event) {
    event.preventDefault();
    $("#filterPage").val(1);
    getAjaxData();
  }, 800)
);

$(document).on("click", ".formReset", function(event) {
  event.preventDefault();
  clearFormFields();
  $("#filterPage").val(1);
  getAjaxData();
});

$(document).on("click", ".delete_btn", function(event) {
  var url = $(this).data("delete_url");
  $('.delete_popup').attr("action", url);
});

var prevKey, prevControl;
$(document).on('keydown', '.only_numbers', function(event) {
  // Allow special keys: backspace, tab, delete, home, end, arrow keys, ctrl+a
  if (
    event.keyCode == 8 ||   // backspace
    event.keyCode == 9 ||   // tab
    event.keyCode == 46 ||  // delete
    (event.keyCode >= 35 && event.keyCode <= 40) ||  // arrow keys/home/end
    (event.keyCode >= 48 && event.keyCode <= 57) ||  // numbers on keyboard
    (event.keyCode >= 96 && event.keyCode <= 105) || // numbers on keypad
    (event.keyCode == 65 && prevKey == 17 && prevControl == event.currentTarget.id) || // ctrl + a, on same control
    (event.keyCode == 110 && !$(this).val().includes('.')) || // decimal point on keypad (only if not already present)
    (event.keyCode == 190 && !$(this).val().includes('.'))    // decimal point on keyboard (only if not already present)
  ) {
    // If valid key, update prevKey and prevControl
    prevKey = event.keyCode;
    prevControl = event.currentTarget.id;
  } else {
    // Prevent invalid input
    event.preventDefault();
  }
});

$(document).on("change", "#stay_months", function(event) {
  $('#stay_months').val($(this).val());
  if ($(this).val() !== '')
    calculateTotal();
});

$(document).on("change", "#other_charges", function(event) {
  if ($(this).val() === 'Yes') {
    $('.hidden_charges').removeClass('d-none');
  } else {
    $('.hidden_charges').addClass('d-none');
    // $("input[name='dewa_ch']").val('');
    // $("input[name='wifi_ch']").val('');
    $("input[name='admin_ch']").val('');
    $("input[name='sec_ch']").val('');
    calculateTotal();
  }
});

$(document).on("change", "#deposit_by", function(event) {
  if ($(this).val() === 'Other') {
    $('.depositor_data').removeClass('d-none');
  } else {
    $('.depositor_data').addClass('d-none');
    $("input[name='dep_name']").val('');
    $("input[name='dep_email']").val('');
    $("input[name='dep_contact']").val('');
  }
});

// $(document).on("input", "input[name='dewa_ch']", function(event) { 
//   $("input[name='dewa_ch']").val($(this).val());
//   calculateTotal();
// });

// $(document).on("input", "input[name='wifi_ch']", function(event) { 
//   $("input[name='wifi_ch']").val($(this).val());
//   calculateTotal();
// });

$(document).on("input", "input[name='admin_ch']", function(event) { 
  $("input[name='admin_ch']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='sec_ch']", function(event) { 
  $("input[name='sec_ch']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='markup_rent']", function(event) { 
  $("input[name='markup_rent']").val($(this).val());
  calculateTotal();
});

function calculateTotal() {
  var stay = $('#stay_months').val();
  var rent = parseFloat($('input[name="prop_rent"]').val()) || 0;
  var markup_rent = parseFloat($('input[name="markup_rent"]').val()) || 0;
  // var dewa = parseFloat($('input[name="dewa_ch"]').val()) || 0;
  // var wifi = parseFloat($('input[name="wifi_ch"]').val()) || 0;
  var admin = parseFloat($('input[name="admin_ch"]').val()) || 0;
  var security = parseFloat($('input[name="sec_ch"]').val()) || 0;
  var advance_rent = 0;

  if (stay > 1)
    advance_rent = ((rent * stay) + (markup_rent * stay)) - rent;
  else 
    advance_rent = (rent * stay) + markup_rent - rent;

  var total = rent + advance_rent + admin + security;
  $('input[name="net_total"]').val(total);
}

// delay ajax request call on keypress, keyup, keydown, change event etc.
function throttle(f, delay) {
  var timer = null;
  return function() {
    var context = this,
      args = arguments;
    clearTimeout(timer);
    timer = window.setTimeout(function() {
      f.apply(context, args);
    }, delay || 800);
  };
}

function extract_key_and_values(metadata = "") {
  // Check if metadata is retrieved successfully
  if (metadata) {
    // Remove any unwanted characters (e.g., '@')
    metadata = metadata.replace('@', '');

    // Split the string by commas to get key-value pairs
    var pairs = metadata.split(',');

    // Initialize an object to hold the extracted key-value pairs
    var result = {};

    // Loop through each pair
    $.each(pairs, function (index, pair) {
      // Split each pair by '=' to separate keys and values
      var parts = pair.split('=');
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
    success: function(response) {
      $(".loaderOverlay").fadeOut();
      $("#table_data").html(response);
    }
  });
}

/**
 * Function to make a dynamic AJAX GET request
 * @param {string} url - The URL to which the request is sent
 * @param {object} data - Data to be sent to the server
 * @param {function} successCallback - A function to be called if the request succeeds
 * @param {function} errorCallback - A function to be called if the request fails
 */
function dynamicAjaxGetRequest(url, data, successCallback, errorCallback, extraParam) {
  $.ajax({
    url: url,
    type: 'GET',
    data: data,
    // dataType: 'json',
    success: function(response) {
      if (typeof successCallback === 'function') {
        successCallback(response, extraParam);
      }
    },
    error: function(xhr, status, error) {
      if (typeof errorCallback === 'function') {
        errorCallback(xhr, status, error);
      }
    }
  });
}

/**
 * Function to make a dynamic AJAX POST request
 * @param {string} url - The URL to which the request is sent
 * @param {object} data - Data to be sent to the server
 * @param {function} successCallback - A function to be called if the request succeeds
 * @param {function} errorCallback - A function to be called if the request fails
 */
function dynamicAjaxRequest(url, method, data, successCallback, errorCallback) {
  $.ajax({
    url: url,
    type: method,
    data: data,
    dataType: 'json',
    success: function(response) {
      if (typeof successCallback === 'function') {
        successCallback(response);
      }
    },
    error: function(xhr, status, error) {
      if (typeof errorCallback === 'function') {
        errorCallback(xhr, status, error);
      }
    }
  });
}
