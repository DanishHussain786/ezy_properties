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

//   setTimeout(function() {
//     $(".alert-success").hide();
//   }, 4000);

//   $("#theme_layout").click(function(event) {
//     $.ajax({
//       headers: {
//         "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
//       },
//       method: "post",
//       url: base_url + "/theme_mode",
//       success: function(data) {
//         if (data.record.theme_mode == "Light") {
//           $("html").removeClass("dark-layout");
//           $("html").addClass("light-layout");
//           $("i").removeClass("sun");
//           $("i").addClass("moon");
//           $("div").removeClass("menu-dark");
//           $("div").addClass("menu-light");
//           $("nav").removeClass("navbar-dark");
//           $("nav").addClass("navbar-light");
//         } else {
//           $("html").addClass("dark-layout");
//           $("html").removeClass("light-layout");
//           $("i").addClass("sun");
//           $("i").removeClass("moon");
//           $("div").addClass("menu-dark");
//           $("div").removeClass("menu-light");
//           $("nav").addClass("navbar-dark");
//           $("nav").removeClass("navbar-light");
//         }
//       },
//       error: function(e) {},
//     });
//   });

/*
  $(document).on(
    "click",
    "#delButton, #block_user, #payment_trigger",
    function(event) {
      var btn_txt = $(this).text().trim();
      var form = $(this).closest("form");
      var name = $(this).data("name");
      event.preventDefault();

      // swal({
      //     title: `Are you sure you want to delete this record?`,
      //     icon: "warning",
      //     buttons: ["No", "Yes"],
      //     dangerMode: true,
      // })
      //     .then((willDelete) => {
      //         if (willDelete) {
      //             form.submit();
      //         }
      //     });

      if (btn_txt === "Block" || btn_txt === "Unblock") {
        swal({
          title: `Are you sure you want to update this record?`,
          icon: "warning",
          buttons: ["No", "Yes"],
          dangerMode: true,
        }).then((willDelete) => {
          if (willDelete) {
            form.submit();
          }
        });
      }

      if (btn_txt === "Payment Status") {
        swal({
          title: `Are you sure you want to update payment status?`,
          icon: "warning",
          buttons: ["Reject", "Approve"],
          dangerMode: true,
        }).then((approve) => {
          if (approve) {
            form.append(
              '<input type="hidden" name="manual_payment" value="1" /> '
            );
            form.submit();
          }
        });
      }
    }
  );
  */

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

  /*
  $(document).on("click", "#viewButton", function(event) {
    let href = $(this).attr("data-url");
    let model_type = $(this).attr("data-model");
    // console.log('href:'+href);
    // console.log('model_type:'+model_type);

    // $('.rate_limiter_btn').html(' UnBlock Ip Address <i class="fa fa-spinner fa-pulse"></i>');

    $.ajax({
      url: href,
      contentType: "application/json",
      dataType: "json",
      beforeSend: function() {},
      success: function(result) {
        if (result.html) {
          // console.log('  ========>> result.html <<========  ');
          // console.log(result.html);
          // return true;

          if (model_type === "task_details") {
            //
          }

          $("#viewModalLabel").html(result.event_title);
          $("#viewBody").html(result.html);

          $("#viewChatBody").html(result.chat_history);

          $("#view_quiz_detail").html(result.view_quiz_detail);
          $("#view_quiz_detail_body").html(
            result.view_quiz_detail_body
          );

          $("#view_quiz_attempt").html(result.view_quiz_attempt);
          $("#view_quiz_attempt_body").html(
            result.view_quiz_attempt_body
          );

          $("#viewQuizAttempt").html(result.chat_history);
        } else {
          $("#viewBody").html(result);
        }

        $("#viewModalEditBtn").attr("href", href + "/edit");
        $("#viewModal").modal("show");
      },
      complete: function() {},
      error: function(jqXHR, testStatus, error) {},
      timeout: 8000,
    });
  });
});
*/

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
    $("input[name='dewa_ch']").val('');
    $("input[name='wifi_ch']").val('');
    $("input[name='admin_ch']").val('');
    $("input[name='sec_ch']").val('');
    calculateTotal();
  }
});

$(document).on("input", "input[name='dewa_ch']", function(event) { 
  $("input[name='dewa_ch']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='wifi_ch']", function(event) { 
  $("input[name='wifi_ch']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='admin_ch']", function(event) { 
  $("input[name='admin_ch']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='sec_ch']", function(event) { 
  $("input[name='sec_ch']").val($(this).val());
  calculateTotal();
});

$(document).on("input", "input[name='grace_rent']", function(event) { 
  $("input[name='grace_rent']").val($(this).val());
  calculateTotal();
});

function calculateTotal() {
  var stay = $('#stay_months').val();
  var rent = parseFloat($('input[name="prop_rent"]').val()) || 0;
  var grace_rent = parseFloat($('input[name="grace_rent"]').val()) || 0;
  var dewa = parseFloat($('input[name="dewa_ch"]').val()) || 0;
  var wifi = parseFloat($('input[name="wifi_ch"]').val()) || 0;
  var admin = parseFloat($('input[name="admin_ch"]').val()) || 0;
  var security = parseFloat($('input[name="sec_ch"]').val()) || 0;
  var advance_rent = 0;

  if (stay > 1)
    advance_rent = ((rent * stay) + (grace_rent * stay)) - rent;
  else 
    advance_rent = (rent * stay) + grace_rent - rent;

  var total = rent + advance_rent + dewa + wifi + admin + security;
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
