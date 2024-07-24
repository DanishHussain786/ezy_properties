<?php

namespace App\Http\Controllers;

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
			'stay_months' 	=> ['required', 'numeric', 'min:1', 'max:12'],
			'prop_rent'     => ['required'],
			'markup_rent'   => ['nullable'],
			'other_charges' => ['required', 'in:Yes,No'],
		);

		// if (isset($request->deposit_by) && $request->deposit_by == 'Other') {
		// 	$rules['dep_name'] = ['required', 'max:100'];
		// 	$rules['dep_email'] = ['required', 'max:100'];
		// 	$rules['dep_contact'] = ['required', 'max:50'];
		// 	$rules['dep_method'] = ['required'];
		// }
		
		$messages = array(
			'user_id.required' => 'Please select guest from list.',
			// 'dep_name.required' => 'Depositor name is required.',
			// 'dep_email.required' => 'Depositor email is required.',
			// 'dep_contact.required' => 'Depositor contact is required.',
			// 'dep_method.required' => 'Depositor pay method is required.',
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

		$rent = isset($request_data['prop_rent']) ? $request_data['prop_rent'] : 0;
		$stay = isset($request_data['stay_months']) ? $request_data['stay_months'] : 0;
		$markup = isset($request_data['markup_rent']) ? $request_data['markup_rent'] : 0;
		// $dewa = isset($request_data['dewa_ch']) ? $request_data['dewa_ch'] : 0;
		// $wifi = isset($request_data['wifi_ch']) ? $request_data['wifi_ch'] : 0;
		$admin = isset($request_data['admin_ch']) ? $request_data['admin_ch'] : 0;
		$sec = isset($request_data['sec_ch']) ? $request_data['sec_ch'] : 0;
		// $deposit = isset($request_data['init_deposit']) ? $request_data['init_deposit'] : 0;

		$tot_rent = $stay * $rent;
		
		$adv_rent = 0;
		if ($stay > 1)
			$adv_rent = (($rent * $stay) + ($markup * $stay)) - $rent;
		else 
			$adv_rent = ($rent * $stay) + $markup - $rent;

		$tot_rent = $rent + $adv_rent + $admin + $sec;

		$last_id = 0;
		$last_data = $this->BookingObj->latest('id')->first();
		if (isset($last_data->id))
			$last_id = $last_data->id + 1;
		else 
			$last_id = 1;

		$booking_data['booked_id'] = generate_random_key().$last_id;
		// $booking_data['booked_by'] = \Auth::user()->id;
		$booking_data['booked_for'] = $request_data['user_id'];
		$booking_data['property_id'] = $request_data['property_id'];
		$booking_data['checkin_date'] = $request_data['checkin_date'];
		$booking_data['checkout_date'] = add_to_datetime($request_data['checkin_date'], ['months' => $stay]);
		$booking_data['for_days'] = datetime_difference($booking_data['checkin_date'], $booking_data['checkout_date'])['days'];
		$booking_data['for_months'] = $stay;
		$booking_data['rent'] = $rent;
		$booking_data['markup_rent'] = $markup;
		$booking_data['other_charges'] = $request_data['other_charges'];
		// $booking_data['dewa_charges'] = $dewa;
		// $booking_data['wifi_charges'] = $wifi;
		$booking_data['admin_charges'] = $admin;
		$booking_data['security_charges'] = $sec;
		$booking_data['balance'] = $tot_rent;
		$booking_data['total_payable'] = $tot_rent;

		$data = $this->BookingObj->saveUpdateBooking($booking_data);
		$data['redirect_url'] = url('property');

		$property = $this->PropertyObj->getProperty(['id' => $request_data['property_id'], 'detail' => true]);
		$property->prop_status = 'Pre-Reserve';
		$property->save();

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

		$markup = $request->input('markup_rent');
		if ($request->has('markup_rent') && ($markup == '' || $markup == 0) )
			$bookings_data->markup_rent = null;

		// $dewa = $request->input('dewa_ch');
		// if ($request->has('dewa_ch') && ($dewa == '' || $dewa == 0) )
		// 	$bookings_data->dewa_charges = null;

		// $wifi = $request->input('wifi_ch');
		// if ($request->has('wifi_ch') && ($wifi == '' || $wifi == 0) )
		// 	$bookings_data->wifi_charges = null;

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

		$bookings['update_id'] = $request_data['update_id'];
		$bookings['booked_for'] = $request_data['booked_for'];
		$bookings['property_id'] = $request_data['property_id'];
		$bookings['status'] = 'Reservation';
		$bookings['checkin_date'] = $request_data['checkin_date'];
		$bookings['checkout_date'] = add_to_datetime($request_data['checkin_date'], ['months' => $request_data['stay_months']]);
		$bookings['for_days'] = datetime_difference($bookings['checkin_date'], $bookings['checkout_date'])['days'];
		$bookings['for_months'] = $request_data['stay_months'];
		$bookings['rent'] = $request_data['prop_rent'];
		$bookings['markup_rent'] = $request_data['markup_rent'];
		$bookings['other_charges'] = $request_data['other_charges'];
		// $bookings['dewa_charges'] = $request_data['dewa_ch'];
		// $bookings['wifi_charges'] = $request_data['wifi_ch'];
		$bookings['admin_charges'] = $request_data['admin_ch'];
		$bookings['security_charges'] = $request_data['sec_ch'];
		$bookings['balance'] = $request_data['net_total'];
		$bookings['total_payable'] = $request_data['net_total'];

		$data = $this->BookingObj->saveUpdateBooking($bookings);
		$data['redirect_url'] = url("{$this->route_name}");
		
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

	// public function payments(Request $request, $id = 0)
	// {
	// 	$request_data = $request->all();

	// 	echo "<pre>";
	// 	echo " request_data"."<br>";
	// 	print_r($request_data);
	// 	echo "</pre>";
	// 	exit("@@@@");

	// 	// [_token] => 8nievg2gK8KAYxkieztvQNKdMF8IV8CFfrOSTupY
  //   // [paying_for] => initial_dep
  //   // [tot_payable] => 1050
  //   // [pay_with] => Online
  //   // [amt_pay] => 102.25
  //   // [comments] => Praesentium in nobis


	// }
}