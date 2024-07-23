<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use App\Models\User;
use App\Models\Property;

class Controller extends BaseController
{
  use AuthorizesRequests, ValidatesRequests;

  public $UserObj;
  public $PropertyObj;

  public function __construct()
  {
    $this->UserObj = new User();
    $this->PropertyObj = new Property();
  }

  /**
   * success response method.
   *
   * @return \Illuminate\Http\Response
   */
  public function sendResponse($result = array(), $message, $count = 0)
  {
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

  public function deleteUser($id = 0, $where_posted_data = array())
  {
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
}
