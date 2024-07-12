<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Transaction extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'transactions';

  // public function booked_by_user()
  // {
  //   return $this->belongsTo(User::class, 'booked_by');
  // }

  // public function booked_for_user()
  // {
  //   return $this->belongsTo(User::class, 'booked_for');
  // }

  // public function property_data()
  // {
  //   return $this->belongsTo(Property::class, 'property_id');
  // }

  // public function skills() {
  //   return $this->hasMany(TransactionInformation::class, 'user_id', 'id')->with('skill_data')
  //     ->where([
  //         ['info_status', '=' ,'Skill'],
  //     ])->select(['id', 'user_id', 'info_status', 'skill_id', 'created_at', 'updated_at']);
  // }

  public function getTransaction($posted_data = array())
  {
    $columns = ['transactions.*'];
    $select_columns = array_merge($columns, []);
    $query = Transaction::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      $query = $query->with('booked_by_user')
        ->with('booked_for_user')
        ->with('property_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('transactions.id', $posted_data['id']);
    }
    if (isset($posted_data['property_id'])) {
      $query = $query->where('transactions.property_id', $posted_data['property_id']);
    }
    if (isset($posted_data['booking_id'])) {
      $query = $query->where('transactions.booking_id', $posted_data['booking_id']);
    }
    if (isset($posted_data['service_id'])) {
      $query = $query->where('transactions.service_id', $posted_data['service_id']);
    }
    if (isset($posted_data['paid_by'])) {
      $query = $query->where('transactions.paid_by', $posted_data['paid_by']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('transactions.id', 'DESC');
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

  public function saveUpdateTransaction($posted_data = array(), $where_posted_data = array())
  {
    $posted_data = array_filter($posted_data);
    if (isset($posted_data['update_id'])) {
      $data = Transaction::find($posted_data['update_id']);
    } else {
      $data = new Transaction;
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

    if (isset($posted_data['property_id'])) {
      $data->property_id = $posted_data['property_id'];
    }
    if (isset($posted_data['booking_id'])) {
      $data->booking_id = $posted_data['booking_id'];
    }
    if (isset($posted_data['service_id'])) {
      $data->service_id = $posted_data['service_id'];
    }
    if (isset($posted_data['paid_by'])) {
      $data->paid_by = $posted_data['paid_by'];
    }
    if (isset($posted_data['deposit_by'])) {
      $data->deposit_by = $posted_data['deposit_by'];
    }
    if (isset($posted_data['dep_name'])) {
      $data->dep_name = ucwords(strtolower($posted_data['dep_name']));
    }
    if (isset($posted_data['dep_email'])) {
      $data->dep_email = $posted_data['dep_email'];
    }
    if (isset($posted_data['dep_contact'])) {
      $data->dep_contact = $posted_data['dep_contact'];
    }
    if (isset($posted_data['dep_method'])) {
      $data->dep_method = $posted_data['dep_method'];
    }
    if (isset($posted_data['sub_tot'])) {
      $data->sub_tot = $posted_data['sub_tot'];
    }
    if (isset($posted_data['vat_amt'])) {
      $data->vat_amt = $posted_data['vat_amt'];
    }
    if (isset($posted_data['discount'])) {
      $data->discount = $posted_data['discount'];
    }
    if (isset($posted_data['paid_amount'])) {
      $data->paid_amount = $posted_data['paid_amount'];
    }
    if (isset($posted_data['balance'])) {
      $data->balance = $posted_data['balance'];
    }
    if (isset($posted_data['grand_tot'])) {
      $data->grand_tot = $posted_data['grand_tot'];
    }
    if (isset($posted_data['paid_for'])) {
      $data->paid_for = $posted_data['paid_for'];
    }
    if (isset($posted_data['type'])) {
      $data->type = $posted_data['type'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = Transaction::getTransaction([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deleteTransaction($id = 0, $where_posted_data = array())
  {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = Transaction::find($id);
    } else {
      $data = Transaction::latest();
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
