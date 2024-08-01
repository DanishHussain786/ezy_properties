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

  $('.dy_prop_number, .dy_room_no, .dy_floor, .dy_rent, .dy_prop_add, .dy_bs_level').css('display', 'none');
});

$(document).on("change", "#prop_type", function(event) { 
  // Clear values of form fields
  $('#prop_number, #room_no, #prop_floor, #prop_rent, #prop_address, #bs_level').each(function() {
    if ($(this).is('select')) {
      $(this).val('').trigger("change"); // Reset select to first option
    } else {
      $(this).val(''); // Clear input field value
    }
  });

  $('.dy_prop_number, .dy_room_no, .dy_floor, .dy_rent, .dy_prop_add, .dy_bs_level').css('display', 'none');

  var val = $(this).val();
  $("#property_type").text(val ? val + " No." : "Property No.");  


  if (val === "Villa" || val === "Appartment" || val === "Studio" || val === "Room") {
    $('.dy_prop_number, .dy_floor, .dy_rent, .dy_prop_add').css('display', 'block');
  }
  else if (val === "Bed Space") {
    $('.dy_room_no, .dy_rent, .dy_bs_level').css('display', 'block');
  }   

  // var btn_txt = $(this).text().trim();
  // var form = $(this).closest("form");
  // var name = $(this).data("name");
  // event.preventDefault();


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

  // if (btn_txt === "Block" || btn_txt === "Unblock") {
  //   swal({
  //     title: `Are you sure you want to update this record?`,
  //     icon: "warning",
  //     buttons: ["No", "Yes"],
  //     dangerMode: true,
  //   }).then((willDelete) => {
  //     if (willDelete) {
  //       form.submit();
  //     }
  //   });
  // }

  // if (btn_txt === "Payment Status") {
  //   swal({
  //     title: `Are you sure you want to update payment status?`,
  //     icon: "warning",
  //     buttons: ["Reject", "Approve"],
  //     dangerMode: true,
  //   }).then((approve) => {
  //     if (approve) {
  //       form.append(
  //         '<input type="hidden" name="manual_payment" value="1" /> '
  //       );
  //       form.submit();
  //     }
  //   });
  // }
});

$(document).on("change", "#other_charges", function(event) {
  if ($(this).val() === 'Yes') {
    $('.hidden_charges').removeClass('d-none');
  } else {
    $('.hidden_charges').addClass('d-none');
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

function calculateTotal() {
  var dewa = parseFloat($('input[name="dewa_ch"]').val()) || 0;
  var wifi = parseFloat($('input[name="wifi_ch"]').val()) || 0;
  var admin = parseFloat($('input[name="admin_ch"]').val()) || 0;
  var security = parseFloat($('input[name="sec_ch"]').val()) || 0;

  var total = dewa + wifi + admin + security;
  $('input[name="net_total"]').val(total);
}


/*
  $(document).on(
    "click",
    ".pagination_links .pagination a",
    function(event) {
      event.preventDefault();

      var page = $(this).attr("href").split("page=")[1];
      $("#filterPage").val(page);
      getAjaxData();
    }
  );

  $(document).on(
    "change",
    ".formFilter",
    throttle(function(event) {
      event.preventDefault();

      $("#filterPage").val(1);
      getAjaxData();
    }, 200)
  );

  $(document).on(
    "keyup",
    ".formFilter",
    throttle(function(event) {
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
  var route = $("#route_name").val();
  if (route === "service") {
    $("#select2-category").select2("val", "");
    $("#select2-category").val("").trigger("change");
    $("#title").val("");
    $("#select2-orderBy_name").select2("val", "");
    $("#select2-orderBy_name").val("").trigger("change");
    $("#select2-orderBy_value").select2("val", "");
    $("#select2-orderBy_value").val("").trigger("change");
  }
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

      if (feather) {
        feather.replace({
          width: 14,
          height: 14,
        });
      }
    },
  });
}
*/