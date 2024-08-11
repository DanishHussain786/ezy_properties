<input type="hidden" value="" id="book_id" name="book_id">
<input type="hidden" value="" id="prop_id" name="prop_id">
<input type="hidden" value="" id="user_id" name="user_id">
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Charges</label>
  <input type="number" value="" id="tot_payable" name="tot_payable" placeholder="Enter payable charges" class="form-control full_width" readonly>
</div>
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">VAT (5%)</label>
  <select class="form-control full_width" id="vat_apply" name="vat_apply">
    <option value="No" selected> No </option>
    <option value="Inclusive"> Inclusive </option>
    <option value="Exclusive"> Exclusive </option>
  </select>
</div>
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Discount</label>
  <input type="text" value="" id="discount" name="discount" placeholder="Enter discount amount" class="form-control full_width only_numbers">
</div>
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Pay Method</label>
  <select class="form-control full_width" id="pay_with" name="pay_with">
    <option value="Cash" selected> Cash </option>
    <option value="Online"> Online </option>
    <option value="Credit-Card"> Credit Card </option>
    <option value="Bank-Transfer"> Bank Transfer </option>
    <option value="Cheque"> Cheque </option>
  </select>
</div>
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Amount Paid</label>
  <input type="text" value="" id="amt_pay" name="amt_pay" placeholder="Enter total amount paid" class="form-control full_width only_numbers">
</div>
<div class="form-group col-md-4 col-sm-6 col-xs-12">
  <label class="control-label">Any comments</label>
  <input type="text" value="" id="comments" name="comments" placeholder="Enter any description or comments" class="form-control full_width">
</div>

<div class="col-md-7"></div>
<div class="col-md-5 text-right" style="padding-top: 15px; display: grid;">
  <div class="summary-row">
    <p class="summary-label"><strong>Sub Total:</strong></p>
    <p class="summary-value" id="sum_st">0</p>
  </div>
  <div class="summary-row">
    <p class="summary-label"><strong>VAT (5%):</strong></p>
    <p class="summary-value" id="sum_vat">0</p>
  </div>
  <div class="summary-row">
    <p class="summary-label"><strong>Discount:</strong></p>
    <p class="summary-value" id="sum_disc">0</p>
  </div>
  <div class="summary-row">
    <p class="summary-label"><strong>Grand Total:</strong></p>
    <p class="summary-value" id="sum_gt">0</p>
  </div>
  <div class="summary-row">
    <p class="summary-label"><strong>Total Paid:</strong></p>
    <p class="summary-value" id="sum_tp">0</p>
  </div>
  <div class="summary-row">
    <p class="summary-label"><strong>Balance:</strong></p>
    <p class="summary-value" id="sum_bal">0</p>
  </div>
</div>