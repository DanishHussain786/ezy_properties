jQuery(document).ready(function() {
  setTimeout(function() {
    $(".alert-success").hide();
  }, 4000);

  $(document).on("change", "#role", function(event) { 
    // var btn_txt = $(this).text().trim();
    // var form = $(this).closest("form");
    // var name = $(this).data("name");
    // event.preventDefault();

    // var val = $(this).val();
    // alert('deee');

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
  })
});
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