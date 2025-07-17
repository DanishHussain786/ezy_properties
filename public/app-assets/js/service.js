jQuery(document).ready(function () {
  $(".searchable").select2();
  setTimeout(function () {
    $(".alert-success").hide();
    $(".alert-danger").hide();
  }, 4000);
});

$(document).on("click", "#add_service", function(event) {
  event.preventDefault();

  let url = $(this).attr("href");
  $("#service_popup").modal("show");
});
