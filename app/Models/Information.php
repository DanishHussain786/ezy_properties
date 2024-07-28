<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Information extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'informations';

  public function booked_by_user()
  {
    return $this->belongsTo(User::class, 'booked_by');
  }

  public function booked_for_user()
  {
    return $this->belongsTo(User::class, 'booked_for');
  }

  public function property_data()
  {
    return $this->belongsTo(Property::class, 'property_id');
  }

  // public function skills() {
  //   return $this->hasMany(InformationInformation::class, 'user_id', 'id')->with('skill_data')
  //     ->where([
  //         ['info_status', '=' ,'Skill'],
  //     ])->select(['id', 'user_id', 'info_status', 'skill_id', 'created_at', 'updated_at']);
  // }

  public function getInformation($posted_data = array())
  {
    $columns = ['informations.*'];
    $select_columns = array_merge($columns, []);
    $query = Information::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      $query = $query->with('booked_by_user')
        ->with('booked_for_user')
        ->with('property_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('informations.id', $posted_data['id']);
    }
    if (isset($posted_data['first_name'])) {
      $query = $query->where('informations.first_name', 'like', '%' . $posted_data['first_name'] . '%');
    }
    if (isset($posted_data['last_name'])) {
      $query = $query->where('informations.last_name', 'like', '%' . $posted_data['last_name'] . '%');
    }
    if (isset($posted_data['search_query'])) {
      $str = $posted_data['search_query'];
      $query = $query->where(
        function ($query) use ($str) {
          return $query
            ->where('informations.prop_type', 'like', '%' . $str . '%')
            ->orwhere('informations.prop_number', 'like', '%' . $str . '%');
        }
      );
    }
    if (isset($posted_data['status'])) {
      $query = $query->where('informations.status', $posted_data['status']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('informations.id', 'DESC');
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

  public function saveUpdateInformation($posted_data = array(), $where_posted_data = array())
  {
    $posted_data = array_filter($posted_data);
    if (isset($posted_data['update_id'])) {
      $data = Information::find($posted_data['update_id']);
    } else {
      $data = new Information;
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

    if (isset($posted_data['booked_by'])) {
      $data->booked_by = $posted_data['booked_by'];
    }
    if (isset($posted_data['booked_for'])) {
      $data->booked_for = $posted_data['booked_for'];
    }
    if (isset($posted_data['property_id'])) {
      $data->property_id = $posted_data['property_id'];
    }
    if (isset($posted_data['checkin_date'])) {
      $data->checkin_date = $posted_data['checkin_date'];
    }
    if (isset($posted_data['checkout_date'])) {
      $data->checkout_date = $posted_data['checkout_date'];
    }
    if (isset($posted_data['for_days'])) {
      $data->for_days = $posted_data['for_days'];
    }
    if (isset($posted_data['for_months'])) {
      $data->for_months = $posted_data['for_months'];
    }
    if (isset($posted_data['rent'])) {
      $data->rent = $posted_data['rent'];
    }
    if (isset($posted_data['adjust_rent'])) {
      $data->adjust_rent = $posted_data['adjust_rent'];
    }
    if (isset($posted_data['grace_rent'])) {
      $data->grace_rent = $posted_data['grace_rent'];
    }
    if (isset($posted_data['other_charges'])) {
      $data->other_charges = $posted_data['other_charges'];
    }
    if (isset($posted_data['dewa_charges'])) {
      $data->dewa_charges = $posted_data['dewa_charges'];
    }
    if (isset($posted_data['wifi_charges'])) {
      $data->wifi_charges = $posted_data['wifi_charges'];
    }
    if (isset($posted_data['admin_charges'])) {
      $data->admin_charges = $posted_data['admin_charges'];
    }
    if (isset($posted_data['security_charges'])) {
      $data->security_charges = $posted_data['security_charges'];
    }
    if (isset($posted_data['net_total'])) {
      $data->net_total = $posted_data['net_total'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = Information::getInformation([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deleteInformation($id = 0, $where_posted_data = array())
  {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = Information::find($id);
    } else {
      $data = Information::latest();
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