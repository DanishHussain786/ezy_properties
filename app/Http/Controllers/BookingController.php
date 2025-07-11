<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Config;
use App\Models\Booking;
class BookingController extends Controller
{
	private $controller_name_single = "Booking";
	private $controller_name_plural = "Bookings";
	private $route_name = "booking";
	private $model_name = "Bookings";

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$request_data = $request->all();
		$request_data['paginate'] = 10;
		$request_data['relations'] = true;
		$data['records'] = $this->BookingObj->getBooking($request_data);
		$data['route_name'] = $this->route_name;

		// echo "<pre>";
		// echo " data"."<br>";
		// print_r($data);
		// echo "</pre>";
		// exit("@@@@");

		$data['html'] = view("{$this->route_name}.ajax_records", compact('data'));

		if ($request->ajax()) {
			return $data['html'];
		}
		return view("{$this->route_name}.list", compact('data'));
	}

	/**
	 * Show the form for creating a new resource.
	 */
	public function create(Request $request)
	{
		$request_data = $request->all();
		$rules = array(
			'_token'				=> ['required'],
			'book_id'				=> ['required', 'exists:bookings,id'],
			'prop_id'				=> ['required', 'exists:properties,id'],
			'user_id'				=> ['required', 'exists:users,id'],
			'tot_payable' 	=> ['required'],
			'vat_apply' 		=> ['required', 'in:No,Inclusive,Exclusive'],
			'discount' 			=> ['nullable'],
			'pay_with'     	=> ['required', 'in:Cash,Online,Credit-Card,Bank-Transfer,Cheque'],
			'amt_pay'    		=> ['required', 'min:1'],
			'comments'    	=> ['nullable', 'max:250'],
		);

		$messages = array(
			'user_id.required' => 'Please select guest from list.',
			'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return $this->sendError($validator->errors()->first(), ["error" => $validator->errors()->first()]);
		}

		$val_sub_tot = $request->input('tot_payable');
		$val_is_vat = $request->input('vat_apply');
		$val_disc = $request->input('discount');
		$val_method = $request->input('pay_with');
		$val_tot_pay = $request->input('amt_pay');
		$val_comments = $request->input('comments');

		$discount = $val_disc == "" ? 0 : $val_disc;
		$vat_amount = round($val_sub_tot * .05, 2);

		if ($val_is_vat == 'No') {
			$sub_total = round(($val_sub_tot - $discount), 2);
			$vat_amt = 0;
			$grand_total = round($sub_total, 2);
			$tot_paid = round($val_tot_pay, 2);
			$balance = round(($sub_total - $tot_paid), 2);
		}
		else if ($val_is_vat == 'Inclusive') {
			$sub_total = round(($val_sub_tot - $vat_amount), 2);
			$vat_amt = $vat_amount;
			$grand_total = round(($sub_total + $vat_amt - $discount), 2);
			$tot_paid = round($val_tot_pay, 2);
			$balance = round(($val_sub_tot - $val_tot_pay - $discount), 2);
		}
		else if ($val_is_vat == 'Exclusive') {
			$sub_total = round($val_sub_tot, 2);
			$vat_amt = $vat_amount;
			$grand_total = round(($sub_total - $discount + $vat_amt), 2);
			$tot_paid = round($val_tot_pay, 2);
			$balance = round(($val_sub_tot - $val_tot_pay + $vat_amt - $discount), 2);
		}

		if ($request_data['discount'] > $request_data['tot_payable'])
			return $this->sendError("Please enter valid discount amount.", ["error" => "Please enter valid discount amount."]);
		if ($balance < 0)
			return $this->sendError("Please enter valid paid amount.", ["error" => "Please enter valid paid amount."]);

		$cals['cals_sub_total'] = $sub_total;
		$cals['cals_vat_amt'] = $vat_amt;
		$cals['cals_grand_total'] = $grand_total;
		$cals['cals_tot_paid'] = $tot_paid;
		$cals['cals_balance'] = $balance;
		$cals['cals_discount'] = $discount;

		$tranac_data['property_id'] = $request_data['prop_id'];
		$tranac_data['booking_id'] = $request_data['book_id'];
		$tranac_data['paid_by'] = $request_data['user_id'];
		$tranac_data['amount'] = $grand_total;
		$tranac_data['type'] = 'Property';
		$data = $this->TransactionObj->saveUpdateTransaction($tranac_data);

		$bookings_object = $this->BookingObj->getBooking(['id' => $request_data['book_id'], 'detail' => true]);
		$bookings_object->status = 'Check-In';
		$bookings_object->save();

		$data['redirect_url'] = url("{$this->route_name}");

		return $this->sendResponse($data, 'User is checked-in successfully.');
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request_data = $request->all();
		$rules = array(
			'user_id'				=> ['required', 'exists:users,id'],
			'checkin_date' 	=> ['required', 'date_format:Y-m-d'],
			'checkout_date' => ['required', 'date_format:Y-m-d'],
			'prop_rent'     => ['required'],
			'expected_rent' => ['required'],
		);

		$messages = array(
			'user_id.required' => 'Please select guest from list.',
			'checkin_date.required' => 'Please select check-in date.',
			'checkout_date.required' => 'Please select check-out date.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return $this->sendError($validator->errors()->first(), ["error" => $validator->errors()->first()]);
		}

		// if (isset($request_data['init_deposit']) && $request_data['init_deposit'] > 0) {
		// 	if (!isset($request_data['deposit_by'])) {
		// 		return $this->sendError("Please select deposit by from list.", ["error" => "Please select deposit by from list."]);
		// 	}
		// }

		try {
      // Begin the transaction
      DB::beginTransaction();

      $markup = isset($request_data['markup_rent']) ? $request_data['markup_rent'] : 0;
      $expected_rent = isset($request_data['expected_rent']) ? $request_data['expected_rent'] : 0;
      $net_total = isset($request_data['net_total']) ? $request_data['net_total'] : 0;

      $last_id = 0;
      $last_data = $this->BookingObj->latest('id')->first();
      if (isset($last_data->id))
        $last_id = $last_data->id + 1;
      else
        $last_id = 1;

      $booking_data['booked_id'] = generate_random_key().$last_id;
      // $booking_data['booked_by'] = \Auth::user()->id;
      $booking_data['booked_for'] = $request_data['user_id'];
      $booking_data['rent'] = $expected_rent;
      $booking_data['markup_rent'] = $markup;
      $booking_data['balance'] = $net_total;

      $booking = $this->BookingObj->getBooking(['status' => 'Unpaid', 'booked_for' => $request_data['user_id'], 'detail' => true]);

      if (!$booking) {
        $booking_data['total_payable'] = $net_total;
      }
      else {
        $booking->total_payable += $net_total;
        $booking->save();
      }

      $data = $this->BookingObj->saveUpdateBooking($booking_data);
      $data['redirect_url'] = url('property');

      $property = $this->PropertyObj->getProperty(['id' => $request_data['property_id'], 'detail' => true]);
      $property->prop_status = 'Pre-Reserve';
      $property->save();

      // this code will do entry for bookings logs
      $book_log['booking_id'] = isset($data->id) ? $data->id : 0;
      $book_log['property_id'] = isset($request_data['property_id']) ? $request_data['property_id'] : 0;
      $book_log['service_id'] = isset($request_data['service_id']) ? $request_data['service_id'] : 0;
      $book_log['checkin_date'] = isset($request_data['checkin_date']) ? $request_data['checkin_date'] : 0;
      $book_log['checkout_date'] = isset($request_data['checkout_date']) ? $request_data['checkout_date'] : 0;
      $book_log['for_days'] = datetime_difference($book_log['checkin_date'], $book_log['checkout_date'])['days'];
      $book_log['for_months'] = floor($book_log['for_days']/30);
      $book_log['rent'] = isset($request_data['prop_rent']) ? $request_data['prop_rent'] : 0;
      $book_log['disc_rent'] = isset($request_data['disc_rent']) ? $request_data['disc_rent'] : 0;
      $book_log['markup_rent'] = $markup;
      $book_log['charge_rent'] = $net_total;

      if ($book_log['property_id'] > 0)
        $book_log['purpose'] = 'Rent-Charges';
      else if ($book_log['property_id'] > 0)
        $book_log['purpose'] = 'Service-Charges';

      // echo "<pre>";
      // echo " book_log"."<br>";
      // print_r($book_log);
      // echo "</pre>";
      // exit("@@@@");

      $this->BookingLogObj->saveUpdateBookingLog($book_log);

      // If everything is successful, commit the transaction
      DB::commit();

      // if ($deposit > 0) {
      // 	$deposit_data['property_id'] = $request_data['property_id'];
      // 	$deposit_data['booking_id'] = $data->id;
      // 	$deposit_data['paid_by'] = $request_data['user_id'];
      // 	$deposit_data['deposit_by'] = $request_data['deposit_by'];
      // 	$deposit_data['dep_name'] = $request_data['dep_name'];
      // 	$deposit_data['dep_email'] = $request_data['dep_email'];
      // 	$deposit_data['dep_contact'] = $request_data['dep_contact'];
      // 	$deposit_data['dep_method'] = $request_data['dep_method'];
      // 	$deposit_data['amount'] = $deposit;
      // 	$deposit_data['balance'] = $tot_rent - $deposit;
      // 	$deposit_data['paid_for'] = 'Property';
      // 	$deposit_data['type'] = 'Initial-Deposit';
      // 	$this->TransactionObj->saveUpdateTransaction($deposit_data);
      // }
    } catch (\Exception $e) {
      // If there's an exception, rollback the transaction
      DB::rollback();

      // Optionally, you can log the error or rethrow it
      // Log::error('Error in transaction: '.$e->getMessage());
      throw $e; // or handle the exception as needed
    }

		return $this->sendResponse($data, $this->controller_name_single.' is created successfully.');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Request $request, $id = 0)
	{
		$request_data = $request->all();
		if ($id != 0)
			$posted_data['id'] = $id;

		$posted_data['detail'] = true;
		$request_data = array_merge($request_data, $posted_data);
		$request_data['relations'] = true;
		$data = $this->BookingObj->getBooking($request_data);
		// $data['users'] = $this->UserObj->getUser(['role' => 'Guest']);
		// $data['route_name'] = $this->route_name;

		if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_payables') {
			$data['html'] = view("account.partials.model_payables", compact('data'));
		}

		if ($request->ajax()) {
			return $data['html'];
		}
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Request $request, $id = 0)
	{
		$request_data = $request->all();
		$posted_data = array();
		$posted_data['id'] = $id;
		$posted_data['detail'] = true;
		$request_data = array_merge($request_data,$posted_data);
		$request_data['relations'] = true;

		$data = $this->BookingObj->getBooking($request_data);
		$data['users'] = $this->UserObj->getUser(['role' => 'Guest']);
		$data['route_name'] = $this->route_name;

		if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_upd_reservation')
			$data['html'] = view("{$this->route_name}.partials.model_upd_reservation", compact('data'));
		else
			$data['html'] = view("{$this->route_name}.ajax_records", compact('data'));

		if ($request->ajax()) {
			return $data['html'];
		}

		return view("{$this->route_name}.add_edit", compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $id = 0)
	{
		$request_data = $request->all();
		$request_data['update_id'] = $id;
		$rules = array(
			'update_id'			=> ['required', 'exists:' . $this->model_name . ',id'],
			'booked_for'		=> ['required', 'exists:users,id'],
			'checkin_date' 	=> ['required', 'date_format:Y-m-d'],
			'stay_months' 	=> ['required', 'numeric', 'min:1', 'max:12'],
			'prop_rent'     => ['required'],
			'other_charges' => ['required', 'in:Yes,No'],
		);

		$messages = array(
			'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return $this->sendError($validator->errors()->first(), ["error" => $validator->errors()->first()]);
		}

		$bookings_data = $this->BookingObj->getBooking(['id' => $request_data['update_id'], 'detail' => true]);

		$disc_rent = $request->input('disc_rent');
		if ($request->has('disc_rent') && ($disc_rent == '' || $disc_rent == 0) )
			$bookings_data->disc_rent = null;

		$markup = $request->input('markup_rent');
		if ($request->has('markup_rent') && ($markup == '' || $markup == 0) )
			$bookings_data->markup_rent = null;

		$admin = $request->input('admin_ch');
		if ($request->has('admin_ch') && ($admin == '' || $admin == 0) )
			$bookings_data->admin_charges = null;

		$sec = $request->input('sec_ch');
		if ($request->has('sec_ch') && ($sec == '' || $sec == 0) )
			$bookings_data->security_charges = null;

		$total = $request->input('net_total');
		if ($request->has('net_total') && ($total == '' || $total == 0) )
			$bookings_data->net_total = null;

		$bookings_data->save();

		$stay = isset($request_data['stay_months']) ? $request_data['stay_months'] : 1;
		$disc_rent = isset($request_data['disc_rent']) ? $request_data['disc_rent'] : 0;
		$markup_rent = isset($request_data['markup_rent']) ? $request_data['markup_rent'] : 0;

		if ($disc_rent > 0)
			$charge_rent = $request_data['prop_rent'] - $request_data['disc_rent'];
		if ($markup_rent > 0)
			$charge_rent = $request_data['prop_rent'] + $request_data['markup_rent'];

		$bookings['update_id'] = $request_data['update_id'];
		$bookings['booked_for'] = $request_data['booked_for'];
		$bookings['property_id'] = $request_data['property_id'];
		$bookings['status'] = 'Reservation';
		$bookings['checkin_date'] = $request_data['checkin_date'];
		$bookings['checkout_date'] = add_to_datetime($request_data['checkin_date'], ['months' => $request_data['stay_months']]);
		$bookings['for_days'] = datetime_difference($bookings['checkin_date'], $bookings['checkout_date'])['days'];
		$bookings['for_months'] = $request_data['stay_months'];
		$bookings['rent'] = $request_data['prop_rent'];
		$bookings['disc_rent'] = $disc_rent;
		$bookings['charge_rent'] = $charge_rent;
		$bookings['markup_rent'] = $markup_rent;
		$bookings['other_charges'] = $request_data['other_charges'];
		$bookings['admin_charges'] = $request_data['admin_ch'];
		$bookings['security_charges'] = $request_data['sec_ch'];
		$bookings['balance'] = $request_data['net_total'];
		$bookings['total_payable'] = $request_data['net_total'];

		$data = $this->BookingObj->saveUpdateBooking($bookings);
		$data['redirect_url'] = url("{$this->route_name}");

		if (isset($data->id)) {
			$ids_arr = $this->BookingLogObj::where(['booking_id' => $data->id])->pluck('booking_id', 'id')->all();
			$ids_str = get_comma_seperated_strings($ids_arr, true);
			$this->BookingLogObj->deleteBookingLog(0, [], ['column' => 'id', 'ids_str' => $ids_str], true);

			$book_log['booking_id'] = $data->id;
			$book_log['amount'] = $charge_rent * $stay;
			$book_log['purpose'] = 'Rent Charges';
			$book_log['status'] = 'Unpaid';
			$this->BookingLogObj->saveUpdateBookingLog($book_log);

			if ($request_data['admin_ch'] > 0) {
				$book_log['amount'] = $request_data['admin_ch'];
				$book_log['purpose'] = 'Admin Fee';
				$book_log['status'] = 'Unpaid';
				$this->BookingLogObj->saveUpdateBookingLog($book_log);
			}

			if ($request_data['sec_ch'] > 0) {
				$book_log['amount'] = $request_data['sec_ch'];
				$book_log['purpose'] = 'Security Deposit';
				$book_log['status'] = 'Unpaid';
				$this->BookingLogObj->saveUpdateBookingLog($book_log);
			}
		}

		return $this->sendResponse($data, $this->controller_name_single.' is updated successfully.');
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id = 0)
	{
		$this->BookingObj->deleteBooking($id);

		$flash_data = ['message', $this->controller_name_single.' is deleted successfully.'];
		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}");
	}

	public function manage_services(Request $request, $id = 0)
	{
		$request_data = $request->all();
		$request_data['paginate'] = 10;
		$request_data['relations'] = true;
		$data['records'] = $this->BookingObj->getBooking($request_data);
		$data['route_name'] = $this->route_name;

		$data['html'] = view("{$this->route_name}.services_records", compact('data'));

		if ($request->ajax()) {
			return $data['html'];
		}
		return view("{$this->route_name}.list", compact('data'));
	}
}
