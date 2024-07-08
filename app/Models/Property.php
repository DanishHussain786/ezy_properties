<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Property extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'properties';

  public function reservations_data()
  {
    // return $this->hasOne(Booking::class, 'property_id');
      // ->where([
      //   ['status', '=', 'Reservation']
      // ]);
  }

  public function getProperty($posted_data = array())
  {
    $columns = ['properties.*'];
    $select_columns = array_merge($columns, []);
    $query = Property::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      // $query = $query->with('reservations_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('properties.id', $posted_data['id']);
      $posted_data['detail'] = true;
    }
    if (isset($posted_data['first_name'])) {
      $query = $query->where('properties.first_name', 'like', '%' . $posted_data['first_name'] . '%');
    }
    if (isset($posted_data['last_name'])) {
      $query = $query->where('properties.last_name', 'like', '%' . $posted_data['last_name'] . '%');
    }
    if (isset($posted_data['search_query'])) {
      $str = $posted_data['search_query'];
      $query = $query->where(
        function ($query) use ($str) {
          return $query
            ->where('properties.prop_type', 'like', '%' . $str . '%')
            ->orwhere('properties.prop_number', 'like', '%' . $str . '%');
        }
      );
    }
    if (isset($posted_data['prop_status'])) {
      $query = $query->where('properties.prop_status', $posted_data['prop_status']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('properties.id', 'DESC');
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

  public function saveUpdateProperty($posted_data = array(), $where_posted_data = array())
  {
    $posted_data = array_filter($posted_data);
    if (isset($posted_data['update_id'])) {
      $data = Property::find($posted_data['update_id']);
    } else {
      $data = new Property;
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

    if (isset($posted_data['prop_type'])) {
      $data->prop_type = $posted_data['prop_type'];
    }
    if (isset($posted_data['prop_number'])) {
      $data->prop_number = $posted_data['prop_number'];
    }
    if (isset($posted_data['prop_floor'])) {
      $data->prop_floor = $posted_data['prop_floor'];
    }
    if (isset($posted_data['prop_rent'])) {
      $data->prop_rent = $posted_data['prop_rent'];
    }
    if (isset($posted_data['prop_address'])) {
      $data->prop_address = $posted_data['prop_address'];
    }
    if (isset($posted_data['prop_status'])) {
      $data->prop_status = $posted_data['prop_status'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = Property::getProperty([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deleteProperty($id = 0, $where_posted_data = array())
  {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = Property::find($id);
    } else {
      $data = Property::latest();
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
