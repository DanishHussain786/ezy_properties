<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Models\MiscLiability;

class ServiceController extends Controller {
  private $controller_name_single = "Service";
  private $controller_name_plural = "Services";
  private $route_name = "service";
  private $model_name = "misc_liabilities";

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $request_data = $request->all();
    if ($request->input('paginate'))
      $request_data['paginate'] = $request->input('paginate');
    else
      $request_data['paginate'] = 10;

    // $request_data['relations'] = true;
    if (isset($request_data['fetch_all']) && $request_data['fetch_all'] == "true") {
      unset($request_data['paginate']);
    }

    $data['records'] = $this->MiscLiabilityObj->getMiscLiability($request_data);
    $data['route_name'] = $this->route_name;

    if (isset($request_data['render_view']) && $request_data['render_view'] == 'service.ajax_records') {
      $data['html'] = view("{$request_data['render_view']}", compact('data'))->render();
    } else {
      $data['html'] = view("{$this->route_name}.ajax_records", compact('data'));
      if ($request->ajax()) {
        return $data['html'];
      }
    }

    $flash_data = ['message', $this->controller_name_plural . ' are listed successfully.'];

    if ($request->ajax()) {
      $success_arr['message'] = $flash_data;
      return $this->sendResponse($request, $data, $code = 200, $success_arr);
    }
    return view("{$this->route_name}.list", compact('data'));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request) {
    // some code here
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request_data = $request->all();
    $rules = array(
      'title'              => ['required', 'max:250'],
      'description'        => ['nullable', 'max:250'],
      'validity_type'      => ['required', 'in:One-Time,Monthly,Yearly'],
      'type'               => ['required', 'in:Facility,Service'],
      'amount'             => ['required', 'numeric', 'gt:0'],
    );

    $messages = array(
      'title.required' => 'Service name is required.',
    );

    return $this->handleStoreUpdate($request, [
      'class' => MiscLiability::class,
      'rules' => $rules,
      'messages' => $messages,
      'controller_single' => $this->controller_name_single,
      'route' => $this->route_name,
    ]);
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, $id = 0) {
    $request_data = $request->all();
    $posted_data = array();
    $posted_data['detail'] = true;
    if ($id != 0)
      $posted_data['id'] = $id;

    $request_data = array_merge($request_data, $posted_data);

    $rules = array(
      'id' => ['required', 'exists:' . $this->model_name . ',id'],
    );

    $messages = array(
      'title.required' => 'The requested id is invalid.',
    );

    $validator = \Validator::make($request_data, $rules, $messages);

    if ($validator->fails()) {
      return $this->sendError($validator->errors()->first(), ["error" => $validator->errors()->first()]);
    }

    $data = $this->MiscLiabilityObj->getMiscLiability($request_data);
    $data['route_name'] = $this->route_name;

    if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_upd_service') {
      $data['html'] = view("{$this->route_name}.partials.model_upd_service", compact('data'));
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
  public function edit($id = 0) {
    // some code here
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id = 0) {
    $request_data = $request->all();
    $request->merge(['update_id' => $id]);

    $rules = array(
      'update_id'         => ['required', 'exists:' . $this->model_name . ',id'],
      'title'             => ['required', 'max:250'],
      'description'       => ['nullable', 'max:250'],
      'validity_type'     => ['required', 'in:One-Time,Monthly,Yearly'],
      'type'              => ['required', 'in:Facility,Service'],
      'amount'            => ['required', 'numeric', 'gt:0'],

    );

    $messages = array(
      'title.required' => 'Service name is required.',
    );

    return $this->handleStoreUpdate($request, [
      'class' => MiscLiability::class,
      'rules' => $rules,
      'messages' => $messages,
      'controller_single' => $this->controller_name_single,
      'route' => $this->route_name,
    ]);
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request, $id = 0) {
    $data = MiscLiability::find($id);
    if ($data)
      $data->delete();

    $flash_data = "Something went wrong during deletion.";

    if ($data->trashed()) {

    }

    $success_arr['message'] = ['message', $this->controller_name_single . ' is deleted successfully.'];
    return $this->sendResponse($request, [], $code = 200, $success_arr);
  }
}
