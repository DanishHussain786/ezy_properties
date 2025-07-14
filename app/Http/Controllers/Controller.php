<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Property;
use App\Models\Booking;
use App\Models\Service;
use App\Models\Transaction;
use App\Models\Information;
use App\Models\BookingLog;

class Controller extends BaseController {
  use AuthorizesRequests, ValidatesRequests;

  public $UserObj;
  public $PropertyObj;
  public $BookingObj;
  public $ServiceObj;
  public $TransactionObj;
  public $InformationObj;
  public $BookingLogObj;

  public function __construct() {
    $this->UserObj = new User();
    $this->PropertyObj = new Property();
    $this->BookingObj = new Booking();
    $this->ServiceObj = new Service();
    $this->TransactionObj = new Transaction();
    $this->InformationObj = new Information();
    $this->BookingLogObj = new BookingLog();
  }

  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function sendResponse($result = array(), $message, $count = 0) {
    $response = [
      'success' => true,
      'records' => $result,
      'message' => $message,
      'count' => $count,
    ];
    return response()->json($response, 200);
  }

  /**
   * return error response.
   *
   * @return \Illuminate\Http\Response
   */
  /*
  public function sendError($error, $errorMessages = array(), $code = 400)
  {
    $response = [
      'success' => false,
      'message' => $error,
    ];

    if (!empty($errorMessages)) {
      $response['records'] = $errorMessages;
    }

    return response()->json($response, $code);
  }
  */

  /**
   * return error response.
   *
   * @return \Illuminate\Http\Response
   */
  public function sendError($request, $validator, $code = 400) {
    if ($request->ajax()) {
      $response = [
        'status' => $code ?? '422',
        'message' => $validator->errors()->first(),
        'data' => [],
        'validation_errors' => $validator->errors(),
      ];
      return response()->json($response, $code);
    } else {
      return redirect()->back()->withErrors($validator)->withInput();
    }
  }

  public function deleteUser($id = 0, $where_posted_data = array()) {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = User::find($id);
    } else {
      $data = User::latest();
    }

    if (isset($where_posted_data) && count($where_posted_data) > 0) {
      if (isset($where_posted_data['user_status'])) {
        $is_deleted = true;
        $data = $data->where('user_status', $where_posted_data['user_status']);
      }
    }

    if ($is_deleted) {
      return $data->delete();
    } else {
      return false;
    }
  }

  /**
   * Generic update method for any resource
   */
  public function handleStoreUpdate(Request $request, $params = []) {
    $request_data = $request->all(); // Validate the request data
    $validator = Validator::make($request_data, $params['rules']);
    $operation = isset($request_data['update_id']) ? 'updated' : 'created';

    if ($validator->fails()) {
      return $this->sendError($request, $validator, $code ?? 422);
    }

    try {
      // Begin the transaction
      DB::beginTransaction();

      $model = new $params['class']; // Dynamically call the saveUpdate method on the appropriate model
      $data = $model->saveUpdate($request_data);

      DB::commit();
    } catch (\Exception $error) {
      DB::rollback();
      throw $error;  // Or handle the exception as needed
    }

    $flash_data = ['message', "{$params['controller_single']} {$operation} successfully."]; // Prepare success message

    if ($request->ajax()) { // Handle the response
      return $this->sendResponse($request, $data, 200, [
        'message' => $flash_data,
        'redirect_url' => isset($params['route']) ? url($params['route']) : null,
      ]);
    } else {
      \Session::flash($flash_data[0], $flash_data[1]);
      return redirect("/{$params['route']}");
    }
  }
}
