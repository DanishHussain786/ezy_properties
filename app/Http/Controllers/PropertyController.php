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
	private $model_name = "propertie";

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$request_data = $request->all();
		$request_data['paginate'] = 10;
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
			'prop_type'        => ['required', 'in:' . Config::get('constants.propertyTypes.all_keys_str')],
			'prop_number'      => ['required'],
			'prop_floor'       => ['required'],
			'prop_rent'        => ['required'],
			'prop_address'     => ['required', 'max:400'],
		);

		if (isset($request->prop_type) && $request->prop_type == 'Bed Space') {
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

		// $rules = array(
		// 	'first_name'				=> ['required', 'max:20', 'regex:'.Config::get('constants.regexPatterns.Only_Alphabets.regex')],
		// 	'last_name'					=> ['required', 'max:20', 'regex:'.Config::get('constants.regexPatterns.Only_Alphabets.regex')],
		// 	'role'							=> ['required', 'in:'.Config::get('constants.userRoles.all_keys_str')],
		// 	'email' 						=> ['required', 'email', 'unique:users'],
		// 	'profile_photo' 		=> ['nullable', 'mimes:'.Config::get('constants.image.all_keys_str'), 'max:20480'],
		// 	'contact_no' 				=> ['required', 'regex:'.Config::get('constants.regexPatterns.Phone_UAE.regex')],
		// 	'emirates_id' 			=> ['nullable', 'max:50'],
		// 	'emirates_photo' 		=> ['nullable', 'mimes:'.Config::get('constants.image.all_keys_str'), 'max:20480'],
		// 	'passport_id' 			=> ['nullable', 'max:50'],
		// 	'passport_photo' 		=> ['nullable', 'mimes:'.Config::get('constants.image.all_keys_str'), 'max:20480'],
		// 	'home_address' 			=> ['nullable', 'max:200'],
		// 	'dob' 							=> ['nullable', 'date_format:m/d/Y'],
		// 	'gender' 						=> ['required', 'in:'.Config::get('constants.userGender.all_keys_str')],
		// 	'status' 						=> ['required', 'in:'.Config::get('constants.userStatus.all_keys_str')],
		// );

		// $messages = array(
		// 	'first_name.regex' => Config::get('constants.regexPatterns.Only_Alphabets.error').' for :attribute.',
		// 	'last_name.regex' => Config::get('constants.regexPatterns.Only_Alphabets.error').' for :attribute.',
		// 	'contact_no.regex' => Config::get('constants.regexPatterns.Phone_UAE.error').' for :attribute.',
		// 	'profile_photo.mimes' => Config::get('constants.image.error').' for :attribute.',
		// 	'emirates_photo.mimes' => Config::get('constants.image.error').' for :attribute.',
		// 	'passport_photo.mimes' => Config::get('constants.image.error').' for :attribute.',
		// 	'gender.in' => Config::get('constants.userGender.error').' for :attribute.',
		// 	'status.in' => Config::get('constants.userStatus.error').' for :attribute.',
		// );

		// $validator = \Validator::make($request_data, $rules, $messages);

		// if ($validator->fails()) {
		// 	return redirect()->back()->withErrors($validator)->withInput();
		// }

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
		if ($id != 0)
			$request_data['id'] = $id;

		$request_data = array();
		$request_data['id'] = $id;
		$request_data['detail'] = true;

		$data = $this->PropertyObj->getProperty($request_data);
		return view("{$this->route_name}.partials.profile", compact('data'));
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

		echo "<pre>";
		echo " request_data"."<br>";
		print_r($request_data);
		echo "</pre>";
		exit("@@@@");

		$request_data['update_id'] = $id;
		$rules = array(
			'update_id'				  => ['required', 'exists:' . $this->model_name . ',id'],
			'first_name'				=> ['nullable', 'max:20', 'regex:'.Config::get('constants.regexPatterns.Only_Alphabets.regex')],
			'last_name'					=> ['nullable', 'max:20', 'regex:'.Config::get('constants.regexPatterns.Only_Alphabets.regex')],
			'role'							=> ['nullable', 'in:'.Config::get('constants.userRoles.all_keys_str')],
			'email' 						=> ['nullable', 'email', 'unique:users,email,'.$id.',id'],
			'profile_photo' 		=> ['nullable', 'mimes:'.Config::get('constants.image.all_keys_str'), 'max:20480'],
			'contact_no' 				=> ['nullable', 'regex:'.Config::get('constants.regexPatterns.Phone_UAE.regex')],
			'emirates_id' 			=> ['nullable', 'max:50'],
			'emirates_photo' 		=> ['nullable', 'mimes:'.Config::get('constants.image.all_keys_str'), 'max:20480'],
			'passport_id' 			=> ['nullable', 'max:50'],
			'passport_photo' 		=> ['nullable', 'mimes:'.Config::get('constants.image.all_keys_str'), 'max:20480'],
			'home_address' 			=> ['nullable', 'max:200'],
			'dob' 							=> ['nullable', 'date_format:m/d/Y'],
			'gender' 						=> ['nullable', 'in:'.Config::get('constants.userGender.all_keys_str')],
			'status' 						=> ['nullable', 'in:'.Config::get('constants.userStatus.all_keys_str')],
		);

		$messages = array(
			'first_name.regex' => Config::get('constants.regexPatterns.Only_Alphabets.error').' for :attribute.',
			'last_name.regex' => Config::get('constants.regexPatterns.Only_Alphabets.error').' for :attribute.',
			'contact_no.regex' => Config::get('constants.regexPatterns.Phone_UAE.error').' for :attribute.',
			'profile_photo.mimes' => Config::get('constants.image.error').' for :attribute.',
			'emirates_photo.mimes' => Config::get('constants.image.error').' for :attribute.',
			'passport_photo.mimes' => Config::get('constants.image.error').' for :attribute.',
			'gender.in' => Config::get('constants.userGender.error').' for :attribute.',
			'status.in' => Config::get('constants.userStatus.error').' for :attribute.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$user_obj = $this->PropertyObj->getProperty(['id' => $request_data['update_id'], 'detail' => true]);

		if ($request->file('profile_photo')) {
			$path = upload_assets($request->profile_photo, 'users', $original = true);
			$request_data['profile_photo'] = $path;
			if (!$path) {
				return redirect()->back()->withErrors([
					'profile_photo' => 'Something wrong with profile photo upload.',
				])->withInput();
			}
			unlink_assets($user_obj['profile_photo']);
		}
		if ($request->file('emirates_photo')) {
			$path = upload_assets($request->emirates_photo, 'users', $original = true);
			$request_data['emirates_photo'] = $path;
			if (!$path) {
				return redirect()->back()->withErrors([
					'emirates_photo' => 'Something wrong with emirates photo upload.',
				])->withInput();
			}
			unlink_assets($user_obj['emirates_photo']);
		}
		if ($request->file('passport_photo')) {
			$path = upload_assets($request->passport_photo, 'users', $original = true);
			$request_data['passport_photo'] = $path;
			if (!$path) {
				return redirect()->back()->withErrors([
					'passport_photo' => 'Something wrong with passport photo upload.',
				])->withInput();
			}
			unlink_assets($user_obj['passport_photo']);
		}

		$request_data = array_filter($request_data);

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
}