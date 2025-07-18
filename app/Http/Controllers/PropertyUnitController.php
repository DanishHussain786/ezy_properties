<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\Models\PropertyUnit;
use Illuminate\Support\Facades\Validator;

class PropertyUnitController extends Controller {
  private $controller_name_single = "Property unit";
  private $controller_name_plural = "Property units";
  private $route_name = "property_unit";
  private $model_name = "property_units";

  /**
   * Display a listing of the resource.
   */
  public function index(Request $request) {
    $request_data = $request->all();
    if ( $request->input('paginate') )
      $request_data['paginate'] = $request->input('paginate');
    else
      $request_data['paginate'] = 10;

    // $request_data['relations'] = true;
    if (isset($request_data['fetch_all']) && $request_data['fetch_all'] == "true") {
      unset($request_data['paginate']);
    }

    $data['records'] = $this->PropertyUnitObj->getPropertyUnit($request_data);

    if( isset($request_data['render_view']) && $request_data['render_view'] == 'property.partials.prop_buildings' ) {
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
      // $success_arr['redirect_url'] = url("/{$this->route_name}");

      return $this->sendResponse($request, $data, $code = 200, $success_arr);
    }

  }

  /**
   * Show the form for creating a new resource.
   */
  public function create(Request $request) {
    // $data['prop_types'] = Config::get('constants.propertyTypes.all_keys_arr');
    // $data['route_name'] = $this->route_name;
    // if ($request->ajax()) {
    //   return $data['html'];
    // }
    // return view("{$this->route_name}.add_edit", compact('data'));
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request) {
    $request_data = $request->all();

    $req_type = "store";
    if (!empty($request_data['update_id'])) {
      $req_type = "update";
    }

    $rules = array(
      'update_id'         => ['nullable', 'exists:property_units,id'],
      'property_id'       => [$req_type == "store" ? 'required' : 'nullable', 'exists:property,id'],
      'unit_type'         => [$req_type == "store" ? 'required' : 'nullable', 'in:Villa,Studio,Room'],
      'unit_number'       => [$req_type == "store" ? 'required' : 'nullable', 'string'],
      'unit_floor'        => [$req_type == "store" ? 'required' : 'nullable', 'string'],
      'unit_rent'         => [$req_type == "store" ? 'required' : 'nullable', 'numeric', 'gt:0'],
    );

    return $this->handleStoreUpdate($request, [
      'class' => PropertyUnit::class,
      'rules' => $rules,
      'messages' => [],
      'controller_single' => $this->controller_name_single,
      'route' => $this->route_name,
    ]);

    // $validator->after(function ($validator) use ($request, $user) {
    //   if (!Hash::check($request->old_password, $user->password)) {
    //     $validator->errors()->add('old_password', 'The provided old password does not match our records.');
    //   }
    // });

    // $validator = Validator::make($request_data, $rules, $messages = []);

    // if ($validator->fails()) {
    //   if ($request->ajax())
    //     return $this->sendError($request, $validator, $code = 422);
    //   else
    //     return redirect()->back()->withErrors($validator)->withInput();
    // }

    // if (!empty($request_data['update_id'])) {
    //   $prop_obj = $this->PropertyUnitObj->getPropertyUnit([
    //     'id' => $request_data['update_id']
    //   ]);

    //   $prop_obj->load('property_units');

    //   if (in_array($request_data['prop_type'], ['Villa', 'Studio', 'Room'])) {
    //     $fillables = $this->PropertyUnitObj->getFillable();
    //     $prop_units_params = $request->only($fillables);
    //     $prop_units_params['property_id'] = $request_data['update_id'];

    //     if ($prop_obj->property_units->count() > 0) {
    //       foreach ($prop_obj['property_units'] as $key => $value) {
    //         if ($value['property_id'] == $request_data['update_id']) {
    //           $prop_units_params['update_id'] = $value['id'];
    //         }
    //       }
    //     }
    //   }

      // $this->PropertyUnitObj->saveUpdate($prop_units_params);
    // }

    // if (isset($request->prop_type) && $request->prop_type != 'Bed Space') {
    // 	$rules['unit_number'] = ['required'];
    // 	$rules['unit_floor'] = ['required'];
    // 	$rules['prop_address'] = ['required', 'max:400'];
    // }
    // else if (isset($request->prop_type) && $request->prop_type == 'Bed Space') {
    // 	$rules['room_no'] = ['required'];
    // 	$rules['bs_level'] = ['required', 'in:1,2,3'];
    // }

    // $messages = array(
    // 	'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
    // );

    // $validator = \Validator::make($request_data, $rules, $messages);

    // if ($validator->fails()) {
    // 	return redirect()->back()->withErrors($validator)->withInput();
    // }

    // $data = $this->PropertyUnitObj->saveUpdate($request_data);
    // $data->load(['property_units' => function ($query) use ($data) {
    //   $query->where('property_id', $data->id);
    // }]);

    // $render_html = "";
    // $flash_data = ['message', $this->controller_name_single . ' is ' . ($req_type == "update" ? 'updated ' : 'created ') . 'successfully.'];

    // if (!empty($request_data['prop_type']) && $request_data['prop_type'] == 'Building')
    //   $render_html = view("property.partials.prop_buildings", compact('data'))->render();
    // else
    //   $render_html = view("property.partials.prop_types", compact('data'))->render();

    // if (isset($data->id)) {
    //   if ($request->ajax()) {
    //     return $this->sendResponse($request, $data, 200, [
    //       'message' => $flash_data,
    //       'redirect_url' => isset($params['route']) ? url($params['route']) : null,
    //       'extra_data' => [
    //         'render_html' => isset($render_html) ? $render_html : null,
    //       ]
    //     ]);
    //   }
    // }

    // $prop_data['prop_type'] = isset($request_data['prop_type']) ? $request_data['prop_type'] : '';
    // $prop_data['unit_number'] = isset($request_data['unit_number']) ? $request_data['unit_number'] : '';
    // $prop_data['unit_floor'] = isset($request_data['unit_floor']) ? $request_data['unit_floor'] : '';
    // $prop_data['other_charges'] = isset($request_data['other_charges']) ? $request_data['other_charges'] : '';
    // $prop_data['dewa_charges'] = isset($request_data['dewa_ch']) ? $request_data['dewa_ch'] : '';
    // $prop_data['wifi_charges'] = isset($request_data['wifi_ch']) ? $request_data['wifi_ch'] : '';
    // $prop_data['misc_charges'] = isset($request_data['misc_ch']) ? $request_data['misc_ch'] : '';
    // $prop_data['prop_address'] = isset($request_data['prop_address']) ? $request_data['prop_address'] : '';
    // $prop_data['unit_rent'] = isset($request_data['unit_rent']) ? $request_data['unit_rent'] : 0;
    // $prop_data['prop_net_rent'] = 0;

    // $prop_data['prop_net_rent'] += $prop_data['unit_rent'];
    // if ( $prop_data['dewa_charges'] > 0 )
    // 	$prop_data['prop_net_rent'] += $prop_data['dewa_charges'];
    // if ( $prop_data['wifi_charges'] > 0 )
    // 	$prop_data['prop_net_rent'] += $prop_data['wifi_charges'];
    // if ( $prop_data['misc_charges'] > 0 )
    // 	$prop_data['prop_net_rent'] += $prop_data['misc_charges'];

    // $this->PropertyUnitObj->saveUpdatePropertyUnit($prop_data);
    // $flash_data = ['message', $this->controller_name_single . ' is created successfully.'];
    // \Session::flash($flash_data[0], $flash_data[1]);
    // return redirect("/{$this->route_name}");
  }

  /**
   * Display the specified resource.
   */
  public function show(Request $request, $id = 0) {
    // some code here
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Request $request, $id = 0) {
    // $request_data = $request->all();
    // $posted_data = array();
    // $posted_data['id'] = $id;
    // $posted_data['detail'] = true;
    // $request_data = array_merge($request_data, $posted_data);

    // $data = $this->PropertyUnitObj->getPropertyUnit($request_data);
    // $data['route_name'] = $this->route_name;

    // if (isset($request_data['return_to']) && $request_data['return_to'] == 'model_update_prop')
    //   $data['html'] = view("{$this->route_name}.partials.model_update_prop", compact('data'));
    // else
    //   $data['html'] = view("{$this->route_name}.ajax_records", compact('data'));

    // if ($request->ajax()) {
    //   return $data['html'];
    // }

    // return view("{$this->route_name}.add_edit", compact('data'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, $id = 0) {
    // $request_data = $request->all();
    // $request_data['update_id'] = $id;
    // $rules = array(
    //   'update_id'      => ['required', 'exists:' . $this->model_name . ',id'],
    //   'prop_type'     => ['nullable', 'in:' . Config::get('constants.propertyTypes.all_keys_str')],
    //   'unit_rent'     => ['nullable'],
    //   'other_charges' => ['nullable', 'in:Yes,No'],
    // );

    // if (isset($request->prop_type) && $request->prop_type != 'Bed Space') {
    //   $rules['unit_number'] = ['nullable'];
    //   $rules['unit_floor'] = ['nullable'];
    //   $rules['prop_address'] = ['nullable', 'max:400'];
    // } else if (isset($request->prop_type) && $request->prop_type == 'Bed Space') {
    //   $rules['room_no'] = ['nullable'];
    //   $rules['bs_level'] = ['nullable', 'in:1,2,3'];
    // }

    // $messages = array(
    //   'prop_type.in' => Config::get('constants.propertyTypes.error') . ' for :attribute.',
    // );

    // $validator = \Validator::make($request_data, $rules, $messages);

    // if ($validator->fails()) {
    //   return redirect()->back()->withErrors($validator)->withInput();
    // }

    // $prop_data['update_id'] = $request_data['update_id'];
    // $prop_data['prop_type'] = isset($request_data['prop_type']) ? $request_data['prop_type'] : '';
    // $prop_data['unit_number'] = isset($request_data['unit_number']) ? $request_data['unit_number'] : '';
    // $prop_data['unit_floor'] = isset($request_data['unit_floor']) ? $request_data['unit_floor'] : '';
    // $prop_data['other_charges'] = isset($request_data['other_charges']) ? $request_data['other_charges'] : '';
    // $prop_data['dewa_charges'] = isset($request_data['dewa_ch']) ? $request_data['dewa_ch'] : '';
    // $prop_data['wifi_charges'] = isset($request_data['wifi_ch']) ? $request_data['wifi_ch'] : '';
    // $prop_data['misc_charges'] = isset($request_data['misc_ch']) ? $request_data['misc_ch'] : '';
    // $prop_data['prop_address'] = isset($request_data['prop_address']) ? $request_data['prop_address'] : '';
    // $prop_data['unit_rent'] = isset($request_data['unit_rent']) ? $request_data['unit_rent'] : 0;
    // $prop_data['prop_net_rent'] = 0;

    // $prop_data['prop_net_rent'] += $prop_data['unit_rent'];
    // if ($prop_data['dewa_charges'] > 0)
    //   $prop_data['prop_net_rent'] += $prop_data['dewa_charges'];
    // else
    //   $prop_data['dewa_charges'] = 'set_null';
    // if ($prop_data['wifi_charges'] > 0)
    //   $prop_data['prop_net_rent'] += $prop_data['wifi_charges'];
    // else
    //   $prop_data['wifi_charges'] = 'set_null';
    // if ($prop_data['misc_charges'] > 0)
    //   $prop_data['prop_net_rent'] += $prop_data['misc_charges'];
    // else
    //   $prop_data['misc_charges'] = 'set_null';

    // $data = $this->PropertyUnitObj->saveUpdatePropertyUnit($prop_data);
    // if ($data->id)
    //   $flash_data = ['message', $this->controller_name_single . ' is updated successfully.'];
    // else
    //   $flash_data = ['error_message', 'Something went wrong during update ' . $this->controller_name_single];

    // \Session::flash($flash_data[0], $flash_data[1]);
    // return redirect("/{$this->route_name}");
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id = 0) {
    // $this->PropertyUnitObj->deletePropertyUnit($id);

    // $flash_data = ['message', $this->controller_name_single . ' is deleted successfully.'];
    // \Session::flash($flash_data[0], $flash_data[1]);
    // return redirect("/{$this->route_name}");
  }
}
