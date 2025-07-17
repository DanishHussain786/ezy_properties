<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Models\MiscLiability;
class ServiceController extends Controller
{
	private $controller_name_single = "Service";
	private $controller_name_plural = "Services";
	private $route_name = "service";
	private $model_name = "misc_liabilities";

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$request_data = $request->all();
		$request_data['paginate'] = 10;
		$data['records'] = $this->MiscLiabilityObj->getMiscLiability($request_data);
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
			'title'						=> ['required', 'max:250'],
			'charges'					=> ['required', 'max:250'],
			'type'						=> ['required', 'in:One-Time,Monthly']
		);

		$messages = array(
			'title.required' => 'Service name is required.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$this->ServiceObj->saveUpdateService($request_data);
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
		// $request_data = $request->all();
		// if ($id != 0)
		// 	$request_data['id'] = $id;

		// $request_data = array();
		// $request_data['id'] = $id;
		// $request_data['detail'] = true;

		// $data = $this->ServiceObj->getService($request_data);
		// return view("{$this->route_name}.partials.profile", compact('data'));
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit($id = 0)
	{
		$request_data = array();
		$request_data['id'] = $id;
		$request_data['detail'] = true;

		$data = $this->ServiceObj->getService($request_data);
		$data['route_name'] = $this->route_name;
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
			'update_id'				=> ['required', 'exists:' . $this->model_name . ',id'],
			'title'						=> ['required', 'max:250'],
			'charges'					=> ['required', 'max:250'],
			'type'						=> ['required', 'in:One-Time,Monthly']

		);

		$messages = array(
			'title.required' => 'Service name is required.',
		);

		$validator = \Validator::make($request_data, $rules, $messages);

		if ($validator->fails()) {
			return redirect()->back()->withErrors($validator)->withInput();
		}

		$data = $this->ServiceObj->saveUpdateService($request_data);
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
	public function destroy(Service $user)
	{
		// $user->delete();

		// $flash_data = ['message', $this->controller_name_single.' is deleted successfully.'];
		// \Session::flash($flash_data[0], $flash_data[1]);
		// return redirect("/{$this->route_name}");
	}
}
