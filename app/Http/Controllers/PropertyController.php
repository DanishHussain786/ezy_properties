<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Models\Property;
class PropertyController extends Controller
{
	private $controller_name_single = "Property";
	private $controller_name_plural = "Properties";
	private $route_name = "property";
	private $model_name = "properties";

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$request_data = $request->all();
		$request_data['paginate'] = 10;
		$request_data['relations'] = true;
		$data['records'] = $this->PropertyObj->getProperty($request_data);
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
		$data['prop_types'] = Config::get('constants.propertyTypes.all_keys_arr');
		$data['route_name'] = $this->route_name;
		if ($request->ajax()) {
			return $data['html'];
		}
		return view("{$this->route_name}.add_edit", compact('data'));
	}

	/**
	 * Store a newly created resource in storage.
	 */
	public function store(Request $request)
	{
		$request_data = $request->all();
		$rules = array(
			'prop_type'     => ['required', 'in:' . Config::get('constants.propertyTypes.all_keys_str')],
			'prop_rent'     => ['required'],
		);
		
		if (isset($request->prop_type) && $request->prop_type != 'Bed Space') {
			$rules['prop_number'] = ['required'];
			$rules['prop_floor'] = ['required'];
			$rules['prop_address'] = ['required', 'max:400'];
		}
		else if (isset($request->prop_type) && $request->prop_type == 'Bed Space') {
			$rules['room_no'] = ['required'];
			$rules['bs_level'] = ['required', 'in:1,2,3'];
		}

		$messages = array(
			'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$this->PropertyObj->saveUpdateProperty($request_data);
		$flash_data = ['message', $this->controller_name_single . ' is created successfully.'];
		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}");
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Request $request, $id = 0)
	{
		// $id = \Crypt::decrypt($id); 
		$request_data = $request->all();		
		$posted_data = array();

		if ($id != 0)
			$posted_data['id'] = $id;

		$posted_data['detail'] = true;
		$request_data = array_merge($request_data,$posted_data);
		$data = $this->PropertyObj->getProperty($request_data);
		$data['users'] = $this->UserObj->getUser(['role' => 'Guest']);
		$data['route_name'] = $this->route_name;

		if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_reservation') {
			$data['html'] = view("{$this->route_name}.partials.model_reservation", compact('data'));
		}

		if ($request->ajax()) {
			return $data['html'];
		}

		print_r($data);
		exit();
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

		$data = $this->PropertyObj->getProperty($request_data);
		$data['route_name'] = $this->route_name;

		if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_update_prop')
			$data['html'] = view("{$this->route_name}.partials.model_update_prop", compact('data'));
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
			'prop_type'     => ['nullable', 'in:' . Config::get('constants.propertyTypes.all_keys_str')],
			'prop_rent'     => ['nullable'],
		);
		
		if (isset($request->prop_type) && $request->prop_type != 'Bed Space') {
			$rules['prop_number'] = ['nullable'];
			$rules['prop_floor'] = ['nullable'];
			$rules['prop_address'] = ['nullable', 'max:400'];
		}
		else if (isset($request->prop_type) && $request->prop_type == 'Bed Space') {
			$rules['room_no'] = ['nullable'];
			$rules['bs_level'] = ['nullable', 'in:1,2,3'];
		}

		$messages = array(
			'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$data = $this->PropertyObj->saveUpdateProperty($request_data);
		if ($data->id)
			$flash_data = ['message', $this->controller_name_single.' is updated successfully.'];
		else 
			$flash_data = ['error_message', 'Something went wrong during update '.$this->controller_name_single];

		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}");
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Property $user)
	{
		$user->delete();

		$flash_data = ['message', $this->controller_name_single.' is deleted successfully.'];
		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}");
	}

	public function manage_booking(Request $request)
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
		
		// $flash_data = ['message', 'Booking is created successfully.'];
		// \Session::flash($flash_data[0], $flash_data[1]);
		// return redirect("/{$this->route_name}");

		// return response()->json(['status' => true, 'data' => $request_data]);

		// echo "<pre>";
		// echo " request_data"."<br>";
		// print_r($request_data);
		// echo "</pre>";
		// exit("@@@@");
	}
}