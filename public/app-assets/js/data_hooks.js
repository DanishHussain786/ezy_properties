jQuery(document).ready(function () {
  $(".searchable").select2();
  setTimeout(function () {
    $(".alert-success").hide();
    $(".alert-danger").hide();
  }, 4000);
});

function fetchItems(params = {}, completed = null ) {
  dynamicAjaxRequest(
    params.endpoint,
    params.method,
    params.data,
    function (response) {
      try {
        var $elem = params.render_resp_in ?? "#list_expenses";
        if (params.prepend_html)
          $($elem).prepend(response.data.html);
        else if (params.append_html)
          $($elem).append(response.data.html);
        else
          $($elem).html(response.data.html);

        completed(true, response.data.html);
        $(".searchable").select2();
      } catch (e) {
        console.error("Error parsing response:", e);
      }
    },
    function (xhr, status, error) {
      Swal.fire("Error!", `There was an error while ajax request.`, "error");
    }
  );
}

function getListing(params = {}, completed = null) {
  dynamicAjaxRequest(
    params.endpoint,
    params.method,
    params.data,
    function (response) {
      try {
        var $elem = params.render_resp_in ?? "#my_div";
        $($elem).html(response.data.html);

        completed(true, response.data.html);
      } catch (e) {
        console.error("Error parsing response:", e);
      }
    },
    function (xhr, status, error) {
      Swal.fire("Error!", `There was an error while ajax request.`, "error");
    }
  );
}

function getFacilityListings() {
  dynamicAjaxRequest("/facility", "GET", { paginate: 10, render_view: "facility.ajax_records" },
    function (response) {
      try {
        $(".dynamic_data").html(response.data.html);
        // completed(true, response.data.html);
      } catch (e) {
        console.error("Error parsing response:", e);
      }
    },
    function (xhr, status, error) {
      Swal.fire("Error!", `Error while getFacilityListings ajax request.`, "error");
    }
  );
}
