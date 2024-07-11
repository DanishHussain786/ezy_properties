<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class BookingLog extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'booking_logs';

  // public function booked_by_user() {
  //   return $this->belongsTo(User::class, 'booked_by');
  // }

  // public function booked_for_user() {
  //   return $this->belongsTo(User::class, 'booked_for');
  // }

  // public function property_data() {
  //   return $this->belongsTo(Property::class, 'property_id');
  // }

  // public function service_data() {
  //   return $this->belongsTo(Service::class, 'service_id');
  // }

  // public function transaction_data() {
  //   return $this->hasOne(Transaction::class, 'booking_id');
  //     // ->where([
  //     //   ['status', '=', 'Reservation']
  //     // ]);
  // }

  // public function skills() {
  //   return $this->hasMany(BookingLogInformation::class, 'user_id', 'id')->with('skill_data')
  //     ->where([
  //         ['info_status', '=' ,'Skill'],
  //     ])->select(['id', 'user_id', 'info_status', 'skill_id', 'created_at', 'updated_at']);
  // }

  public function getBookingLog($posted_data = array())
  {
    $columns = ['booking_logs.*'];
    $select_columns = array_merge($columns, []);
    $query = BookingLog::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      // $query = $query->with('booked_by_user')
      //   ->with('booked_for_user')
      //   ->with('property_data')
      //   ->with('service_data')
      //   ->with('transaction_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('booking_logs.id', $posted_data['id']);
    }
    if (isset($posted_data['first_name'])) {
      $query = $query->where('booking_logs.first_name', 'like', '%' . $posted_data['first_name'] . '%');
    }
    if (isset($posted_data['last_name'])) {
      $query = $query->where('booking_logs.last_name', 'like', '%' . $posted_data['last_name'] . '%');
    }
    if (isset($posted_data['search_query'])) {
      $str = $posted_data['search_query'];
      $query = $query->where(
        function ($query) use ($str) {
          return $query
            ->where('booking_logs.prop_type', 'like', '%' . $str . '%')
            ->orwhere('booking_logs.prop_number', 'like', '%' . $str . '%');
        }
      );
    }
    if (isset($posted_data['status'])) {
      $query = $query->where('booking_logs.status', $posted_data['status']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('booking_logs.id', 'DESC');
    }


    if (isset($posted_data['paginate'])) {
      $result = $query->paginate($posted_data['paginate']);
    } else {
      if (isset($posted_data['detail'])) {
        $result = $query->first();
      } else if (isset($posted_data['count'])) {
        $result = $query->count();
      } else if (isset($posted_data['array'])) {
        $result = $query->get()->ToArray();
      } else {
        $result = $query->get();
      }
    }

    if (isset($posted_data['printsql'])) {
      $result = $query->toSql();
      echo '<pre>';
      print_r($result);
      print_r($posted_data);
      exit;
    }
    return $result;
  }

  public function saveUpdateBookingLog($posted_data = array(), $where_posted_data = array())
  {
    $posted_data = array_filter($posted_data);
    if (isset($posted_data['update_id'])) {
      $data = BookingLog::find($posted_data['update_id']);
    } else {
      $data = new BookingLog;
    }

    if (isset($where_posted_data) && count($where_posted_data) > 0) {
      $is_updated = false;
      if (isset($where_posted_data['user_status'])) {
        $is_updated = true;
        $data = $data->where('user_status', $where_posted_data['user_status']);
      }

      if ($is_updated) {
        return $data->update($posted_data);
      } else {
        return false;
      }
    }

    if (isset($posted_data['booking_id'])) {
      $data->booking_id = $posted_data['booking_id'];
    }
    if (isset($posted_data['amount'])) {
      $data->amount = $posted_data['amount'];
    }
    if (isset($posted_data['purpose'])) {
      $data->purpose = $posted_data['purpose'];
    }
    if (isset($posted_data['status'])) {
      $data->status = $posted_data['status'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = BookingLog::getBookingLog([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deleteBookingLog($id = 0, $where_array = array(), $where_in = array(), $hard_delete = false)
  {
    /********** Sample Values **********
    deleteBookingLog(5);
    deleteBookingLog(0, ['status' => 'Pending', 'title' => 'love']);
    deleteBookingLog(0, [], ['column' => 'id', 'ids_str' => '1,2,11']);
    */

    $is_deleted = false;
    $data = BookingLog::latest();

    if ($id > 0) {
      $is_deleted = true;
      $data = BookingLog::find($id);
    }

    if (isset($where_array) && count($where_array) > 0) {
      foreach ($where_array as $key => $value) {
        $is_deleted = true;
        $data = $data->where($key, $value);
      }
    }

    if (isset($where_in) && count($where_in) > 0) {
      $ids_arr = explode(",", $where_in['ids_str']);
      $is_deleted = true;
      $data = $data->whereIn($where_in['column'], $ids_arr);
    }

    if ($is_deleted) {
      if ($hard_delete)
        return $data->forceDelete();
      else
        return $data->delete();
    } else {
      return false;
    }

    // $is_deleted = false;
    // if ($id > 0) {
    //   $is_deleted = true;
    //   $data = BookingLog::find($id);
    // } else {
    //   $data = BookingLog::latest();
    // }

    // if (isset($where_array) && count($where_array) > 0) {
    //   if (isset($where_array['user_status'])) {
    //     $is_deleted = true;
    //     $data = $data->where('user_status', $where_array['user_status']);
    //   }
    // }
  }
}
