<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Models\Information;
class InformationController extends Controller
{
	private $controller_name_single = "Information";
	private $controller_name_plural = "Informations";
	private $route_name = "info";
	private $model_name = "informations";

	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$request_data = $request->all();
		$request_data['paginate'] = 10;
		$request_data['relations'] = true;
		$data['records'] = $this->InformationObj->getInformation($request_data);
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
		$data = $this->InformationObj->getInformation(['id' => 1, 'detail' => true]);
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
		$request_data['update_id'] = 1;

		if ($request->file('c_logo')) {
			$path = upload_assets($request->c_logo, 'company_data', $original = true);
			$request_data['c_logo'] = $path;
			if (!$path) {
				return redirect()->back()->withErrors([
					'c_logo' => 'Something wrong with logo upload.',
				])->withInput();
			}
		}

		$this->InformationObj->saveUpdateInformation($request_data);
		$flash_data = ['message', $this->controller_name_single . ' is stored successfully.'];
		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}/create");
	}

	/**
	 * Display the specified resource.
	 */
	public function show(Request $request, $id = 0)
	{
    //
	}

	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Request $request, $id = 0)
	{
		// $request_data = $request->all();
		// $posted_data = array();
		// $posted_data['id'] = $id;
		// $posted_data['detail'] = true;
		// $request_data = array_merge($request_data,$posted_data);
		// $request_data['relations'] = true;

		// $data = $this->InformationObj->getInformation($request_data);
		// $data['users'] = $this->UserObj->getUser(['role' => 'Guest']);
		// $data['route_name'] = $this->route_name;

		// if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_upd_reservation')
		// 	$data['html'] = view("{$this->route_name}.partials.model_upd_reservation", compact('data'));
		// else
		// 	$data['html'] = view("{$this->route_name}.ajax_records", compact('data'));

		// if ($request->ajax()) {
		// 	return $data['html'];
		// }

		// return view("{$this->route_name}.add_edit", compact('data'));
	}

	/**
	 * Update the specified resource in storage.
	 */
	public function update(Request $request, $id = 0)
	{
		$request_data = $request->all();
		$info_data = $this->InformationObj->getInformation(['id' => $request_data['update_id'], 'detail' => true]);

		if ($request->file('c_logo')) {
			$path = upload_assets($request->c_logo, 'company_data', $original = true);
			$request_data['c_logo'] = $path;
			if (!$path) {
				return redirect()->back()->withErrors([
					'c_logo' => 'Something wrong with logo upload.',
				])->withInput();
			}
			unlink_assets($info_data['c_logo']);
		}

		$this->InformationObj->saveUpdateInformation($request_data);
		$flash_data = ['message', $this->controller_name_single . ' is stored successfully.'];
		\Session::flash($flash_data[0], $flash_data[1]);
		return redirect("/{$this->route_name}/create");
	}

	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy($id = 0)
	{
		// $this->InformationObj->deleteInformation($id);

		// $flash_data = ['message', $this->controller_name_single.' is deleted successfully.'];
		// \Session::flash($flash_data[0], $flash_data[1]);
		// return redirect("/{$this->route_name}");
	}
}
