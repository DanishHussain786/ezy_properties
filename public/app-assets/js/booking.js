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
});

$(document).on("click", ".update_reservation_btn", function(event) {
  event.preventDefault();
  var update_id = $(this).data("item_id");
  var url = $(this).data("action_url");
  $('.update_popup').attr("action", url);

  dynamicAjaxGetRequest('/booking/'+update_id+'/edit', { 'update_id': update_id, 'return_to': 'model_upd_reservation' }, function(response) {
    try {
      $(".model-ajax").html(response);
      $("#update_reservation_popup").modal("show");
      calculateTotal();
    } catch (e) {
      console.error('Error parsing response:', e);
    }
  }, function(xhr, status, error) {
    console.error('Error:', status, error);
  });
});

$(document).on("click", ".update_reserv_submit", function(event) {
  event.preventDefault();

  let url = $('.update_popup').attr("action");
  var data = $("#upd_reservation").serializeArray();
  dynamicAjaxRequest(url, 'PUT', data, function(response) {
    try {
      toastr.success(response.message);
      $('.update_reserv_submit').prop('disabled', true);
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

$(document).on("click", ".checkin_btn", function(event) {
  event.preventDefault();
  var data_object = extract_key_and_values($(this).data("metadata"));
  $("#book_id").val($(this).data("item_id"));
  $("#prop_id").val(data_object.porp);
  $("#user_id").val(data_object.resu);
  $(".tot_payable").val(data_object.latot);
  $("#checkin_popup").modal("show");
});

$(document).on("click", ".initial_deposit_btn", function(event) {
  event.preventDefault();
  $(".tot_payable").val($(this).data("total"));
  // var data_object = extract_key_and_values($(this).data("metadata"));
  // $("#book_id").val($(this).data("item_id"));
  // $("#prop_id").val(data_object.porp);
  // $("#user_id").val(data_object.resu);
  // $("#tot_payable").val(data_object.latot);
  $("#payment_popup").modal("show");
});

$(document).on("click", "#add_payment_btn", function(event) {
  $('#add_payment_form').submit();
});

$(document).on("click", "#do_checkin_btn", function(event) {
  event.preventDefault();
  var data = $("#create_checkin").serializeArray();  

  var calculations = [
    { name: "sub_total", value: parseFloat($("#sum_st").text()) || 0 },
    { name: "vat_amt", value: parseFloat($("#sum_vat").text()) || 0 },
    { name: "discount", value: parseFloat($("#sum_disc").text()) || 0 },
    { name: "grand_tot", value: parseFloat($("#sum_gt").text()) || 0 },
    { name: "total_paid", value: parseFloat($("#sum_tp").text()) || 0 },
    { name: "balance", value: parseFloat($("#sum_bal").text()) || 0 }
  ];

  data.push(...calculations);
  dynamicAjaxGetRequest('/booking/create', data, function(response) {
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

$(document).on("change", "#vat_apply", function(event) {
  $('#vat_apply').val($(this).val());
  calculateValues();
});

$(document).on("input", "input[name='amt_pay']", function(event) { 
  $("input[name='amt_pay']").val($(this).val());
  calculateValues();
});

$(document).on("input", "input[name='discount']", function(event) { 
  $("input[name='discount']").val($(this).val());
  calculateValues();
});

function calculateValues() {
  var charges = parseFloat($('input[name="tot_payable"]').val()) || 0;
  var vat_apply = $('#vat_apply').val();  
  var discount = parseFloat($('input[name="discount"]').val()) || 0;
  var amt_paid = parseFloat($('input[name="amt_pay"]').val()) || 0;
  var vat_amt = charges * 0.05;
  
  if (vat_apply === 'No') {
    let st = parseFloat(charges - discount) || 0;
    $('#sum_st').text(st);
    $('#sum_vat').text('0');
    $('#sum_disc').text(discount);
    $('#sum_gt').text(st);
    $('#sum_tp').text(amt_paid);
    $('#sum_bal').text(st - amt_paid);
  }
  else if (vat_apply === 'Inclusive') {
    let st = parseFloat(charges - vat_amt) || 0;
    $('#sum_st').text(st);
    $('#sum_vat').text(vat_amt);
    $('#sum_disc').text(discount);
    $('#sum_gt').text(st + vat_amt - discount);
    $('#sum_tp').text(amt_paid);
    $('#sum_bal').text(charges - amt_paid - discount);
  }
  else if (vat_apply === 'Exclusive') {
    // let gt = parseFloat(charges + vat_amt) || 0;
    $('#sum_st').text(charges);
    $('#sum_vat').text(vat_amt);
    $('#sum_disc').text(discount);
    $('#sum_gt').text(charges - discount + vat_amt);
    $('#sum_tp').text(amt_paid);
    $('#sum_bal').text(charges - amt_paid + vat_amt - discount);
  }
}

$('#update_reservation_popup').on('shown.bs.modal', function () {
  $('.select2_field').select2();
});

$('#checkin_popup, #payment_popup').on('hidden.bs.modal', function () {
  $(this).find('form').trigger('reset');
  $('#sum_st').text('0');
  $('#sum_vat').text('0');
  $('#sum_disc').text('0');
  $('#sum_gt').text('0');
  $('#sum_tp').text('0');
  $('#sum_bal').text('0');
})