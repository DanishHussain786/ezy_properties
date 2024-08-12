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
		// $data['prop_types'] = Config::get('constants.propertyTypes.all_keys_arr');
		// $data['route_name'] = $this->route_name;
		// if ($request->ajax()) {
		// 	return $data['html'];
		// }
		// return view("{$this->route_name}.add_edit", compact('data'));
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
			'grace_rent'    => ['nullable'],
			'other_charges' => ['required', 'in:Yes,No'],
		);
	
		$messages = array(
			'user_id.required' => 'Please select guest from list.',
			'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return $this->sendError($validator->errors()->first(), ["error" => $validator->errors()->first()]);
		}
		
		$rent = isset($request_data['prop_rent']) ? $request_data['prop_rent'] : 0;
		$stay = isset($request_data['stay_months']) ? $request_data['stay_months'] : 0;
		$grace = isset($request_data['grace_rent']) ? $request_data['grace_rent'] : 0;
		$dewa = isset($request_data['dewa_ch']) ? $request_data['dewa_ch'] : 0;
		$wifi = isset($request_data['wifi_ch']) ? $request_data['wifi_ch'] : 0;
		$admin = isset($request_data['admin_ch']) ? $request_data['admin_ch'] : 0;
		$sec = isset($request_data['sec_ch']) ? $request_data['sec_ch'] : 0;

		$tot_rent = $stay * $rent;
		
		$adv_rent = 0;
		if ($stay > 1)
			$adv_rent = (($rent * $stay) + ($grace * $stay)) - $rent;
		else 
			$adv_rent = ($rent * $stay) + $grace - $rent;

		$tot_rent = $rent + $adv_rent + $dewa + $wifi + $admin + $sec;

		// $booking_data['booked_by'] = \Auth::user()->id;
		$booking_data['booked_for'] = $request_data['user_id'];
		$booking_data['property_id'] = $request_data['property_id'];
		$booking_data['status'] = 'Reservation';
		$booking_data['checkin_date'] = $request_data['checkin_date'];
		$booking_data['checkout_date'] = add_to_datetime($request_data['checkin_date'], ['months' => $stay]);
		$booking_data['for_days'] = datetime_difference($booking_data['checkin_date'], $booking_data['checkout_date'])['days'];
		$booking_data['for_months'] = $stay;
		$booking_data['rent'] = $rent;
		$booking_data['grace_rent'] = $grace;
		$booking_data['other_charges'] = $request_data['other_charges'];
		$booking_data['dewa_charges'] = $dewa;
		$booking_data['wifi_charges'] = $wifi;
		$booking_data['admin_charges'] = $admin;
		$booking_data['security_charges'] = $sec;
		$booking_data['net_total'] = $tot_rent;

		$data = $this->BookingObj->saveUpdateBooking($booking_data);
		$data['redirect_url'] = url('property');
		
		return $this->sendResponse($data, 'Booking is created successfully.');
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Request $request, $id = 0)
	{
		// $id = \Crypt::decrypt($id); 
		// $request_data = $request->all();		
		// $posted_data = array();

		// if ($id != 0)
		// 	$posted_data['id'] = $id;

		// $posted_data['detail'] = true;
		// $request_data = array_merge($request_data,$posted_data);
		// $data = $this->BookingObj->getBooking($request_data);
		// $data['users'] = $this->UserObj->getUser(['role' => 'Guest']);
		// $data['route_name'] = $this->route_name;

		// if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_reservation') {
		// 	$data['html'] = view("{$this->route_name}.partials.model_reservation", compact('data'));
		// }

		// if ($request->ajax()) {
		// 	return $data['html'];
		// }

		// print_r($data);
		// exit();
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

		$grace = $request->input('grace_rent');
		if ($request->has('grace_rent') && ($grace == '' || $grace == 0) )
			$bookings_data->grace_rent = null;

		$dewa = $request->input('dewa_ch');
		if ($request->has('dewa_ch') && ($dewa == '' || $dewa == 0) )
			$bookings_data->dewa_charges = null;

		$wifi = $request->input('wifi_ch');
		if ($request->has('wifi_ch') && ($wifi == '' || $wifi == 0) )
			$bookings_data->wifi_charges = null;

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
		$bookings['grace_rent'] = $request_data['grace_rent'];
		$bookings['other_charges'] = $request_data['other_charges'];
		$bookings['dewa_charges'] = $request_data['dewa_ch'];
		$bookings['wifi_charges'] = $request_data['wifi_ch'];
		$bookings['admin_charges'] = $request_data['admin_ch'];
		$bookings['security_charges'] = $request_data['sec_ch'];
		$bookings['net_total'] = $request_data['net_total'];

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

	public function manage(Request $request, $id = 0)
	{
		$request_data = $request->all();

		echo "<pre>";
		echo " request_data"."<br>";
		print_r($request_data);
		echo "</pre>";
		exit("@@@@");
	}
}