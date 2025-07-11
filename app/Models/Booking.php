<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Booking extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'bookings';

  public function booked_by_user() {
    return $this->belongsTo(User::class, 'booked_by');
  }

  public function booked_for_user() {
    return $this->belongsTo(User::class, 'booked_for')
      ->select(config('def_columns.users'));
  }

  public function transactions() {
    return $this->hasOne(Transaction::class, 'booking_id');
      // ->where([
      //   ['status', '=', 'Reservation']
      // ]);
  }

  public function booking_logs() {
    return $this->hasMany(BookingLog::class, 'booking_id', 'id')
      ->with(['properties', 'services'])
      ->select(config('def_columns.booking_logs'));
  }

  // public function skills() {
  //   return $this->hasMany(BookingInformation::class, 'user_id', 'id')->with('skill_data')
  //     ->where([
  //         ['info_status', '=' ,'Skill'],
  //     ])->select(['id', 'user_id', 'info_status', 'skill_id', 'created_at', 'updated_at']);
  // }

  public function getBooking($posted_data = array())
  {
    $columns = ['bookings.*'];
    $select_columns = array_merge($columns, []);
    $query = Booking::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      $query = $query->with('booked_by_user')
        ->with('booked_for_user')
        ->with('booking_logs')
        ->with('transactions');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('bookings.id', $posted_data['id']);
    }
    if (isset($posted_data['first_name'])) {
      $query = $query->where('bookings.first_name', 'like', '%' . $posted_data['first_name'] . '%');
    }
    if (isset($posted_data['last_name'])) {
      $query = $query->where('bookings.last_name', 'like', '%' . $posted_data['last_name'] . '%');
    }
    if (isset($posted_data['search_query'])) {
      $str = $posted_data['search_query'];
      $query = $query->where(
        function ($query) use ($str) {
          return $query
            ->where('bookings.prop_type', 'like', '%' . $str . '%')
            ->orwhere('bookings.prop_number', 'like', '%' . $str . '%');
        }
      );
    }
    if (isset($posted_data['status'])) {
      $query = $query->where('bookings.status', $posted_data['status']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('bookings.id', 'DESC');
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

  public function saveUpdateBooking($posted_data = array(), $where_posted_data = array())
  {
    $posted_data = array_filter($posted_data);
    if (isset($posted_data['update_id'])) {
      $data = Booking::find($posted_data['update_id']);
    } else {
      $data = new Booking;
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

    if (isset($posted_data['booked_id'])) {
      $data->booked_id = $posted_data['booked_id'];
    }
    if (isset($posted_data['booked_by'])) {
      $data->booked_by = $posted_data['booked_by'];
    }
    if (isset($posted_data['booked_for'])) {
      $data->booked_for = $posted_data['booked_for'];
    }
    if (isset($posted_data['total_payable'])) {
      $data->total_payable = $posted_data['total_payable'];
    }
    if (isset($posted_data['total_paid'])) {
      $data->total_paid = $posted_data['total_paid'];
    }
    if (isset($posted_data['status'])) {
      $data->status = $posted_data['status'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = Booking::getBooking([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deleteBooking($id = 0, $where_posted_data = array())
  {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = Booking::find($id);
    } else {
      $data = Booking::latest();
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
