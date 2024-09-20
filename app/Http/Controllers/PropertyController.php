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
			'other_charges' => ['required', 'in:Yes,No'],
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

		$prop_data['prop_type'] = isset($request_data['prop_type']) ? $request_data['prop_type'] : '';
		$prop_data['prop_number'] = isset($request_data['prop_number']) ? $request_data['prop_number'] : '';
		$prop_data['prop_floor'] = isset($request_data['prop_floor']) ? $request_data['prop_floor'] : '';
		$prop_data['other_charges'] = isset($request_data['other_charges']) ? $request_data['other_charges'] : '';
		$prop_data['dewa_charges'] = isset($request_data['dewa_ch']) ? $request_data['dewa_ch'] : '';
		$prop_data['wifi_charges'] = isset($request_data['wifi_ch']) ? $request_data['wifi_ch'] : '';
		$prop_data['misc_charges'] = isset($request_data['misc_ch']) ? $request_data['misc_ch'] : '';
		$prop_data['prop_address'] = isset($request_data['prop_address']) ? $request_data['prop_address'] : '';
		$prop_data['prop_rent'] = isset($request_data['prop_rent']) ? $request_data['prop_rent'] : 0;
		$prop_data['prop_net_rent'] = 0;

		$prop_data['prop_net_rent'] += $prop_data['prop_rent'];
		if ( $prop_data['dewa_charges'] > 0 )
			$prop_data['prop_net_rent'] += $prop_data['dewa_charges'];
		if ( $prop_data['wifi_charges'] > 0 )
			$prop_data['prop_net_rent'] += $prop_data['wifi_charges'];
		if ( $prop_data['misc_charges'] > 0 )
			$prop_data['prop_net_rent'] += $prop_data['misc_charges'];

		$this->PropertyObj->saveUpdateProperty($prop_data);
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
		$data['pay_methods'] = Config::get('constants.paymentModes.all_keys_arr');

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
			'other_charges' => ['nullable', 'in:Yes,No'],
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

		$prop_data['update_id'] = $request_data['update_id'];
		$prop_data['prop_type'] = isset($request_data['prop_type']) ? $request_data['prop_type'] : '';
		$prop_data['prop_number'] = isset($request_data['prop_number']) ? $request_data['prop_number'] : '';
		$prop_data['prop_floor'] = isset($request_data['prop_floor']) ? $request_data['prop_floor'] : '';
		$prop_data['other_charges'] = isset($request_data['other_charges']) ? $request_data['other_charges'] : '';
		$prop_data['dewa_charges'] = isset($request_data['dewa_ch']) ? $request_data['dewa_ch'] : '';
		$prop_data['wifi_charges'] = isset($request_data['wifi_ch']) ? $request_data['wifi_ch'] : '';
		$prop_data['misc_charges'] = isset($request_data['misc_ch']) ? $request_data['misc_ch'] : '';
		$prop_data['prop_address'] = isset($request_data['prop_address']) ? $request_data['prop_address'] : '';
		$prop_data['prop_rent'] = isset($request_data['prop_rent']) ? $request_data['prop_rent'] : 0;
		$prop_data['prop_net_rent'] = 0;

		$prop_data['prop_net_rent'] += $prop_data['prop_rent'];
		if ( $prop_data['dewa_charges'] > 0 )
			$prop_data['prop_net_rent'] += $prop_data['dewa_charges'];
		else
			$prop_data['dewa_charges'] = 'set_null';
		if ( $prop_data['wifi_charges'] > 0 )
			$prop_data['prop_net_rent'] += $prop_data['wifi_charges'];
		else
			$prop_data['wifi_charges'] = 'set_null';
		if ( $prop_data['misc_charges'] > 0 )
			$prop_data['prop_net_rent'] += $prop_data['misc_charges'];
		else
			$prop_data['misc_charges'] = 'set_null';

		$data = $this->PropertyObj->saveUpdateProperty($prop_data);
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
	public function destroy($id = 0)
	{
		$this->PropertyObj->deleteProperty($id);

		$flash_data = ['message', $this->controller_name_single.' is deleted successfully.'];
		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}");
	}
}
