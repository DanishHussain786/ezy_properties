<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PropertyUnit extends Model {
  use HasFactory, SoftDeletes;
  protected $table = 'property_units';

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    'property_id',
    'prop_number',
    'prop_floor',
    'prop_rent',
  ];

  // public function reservations_data() {
    // return $this->hasOne(Booking::class, 'property_id');
    // ->where([
    //   ['status', '=', 'Reservation']
    // ]);
  // }

  public function getPropertyUnit($posted_data = array()) {
    $columns = ['property_units.*'];
    $select_columns = array_merge($columns, []);
    $query = PropertyUnit::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      // $query = $query->with('reservations_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('property_units.id', $posted_data['id']);
      $posted_data['detail'] = true;
    }
    if (isset($posted_data['property_id'])) {
      $query = $query->where('property_units.property_id', $posted_data['property_id']);
    }
    // if (isset($posted_data['first_prop_title'])) {
    //   $query = $query->where('property_units.first_name', 'like', '%' . $posted_data['first_name'] . '%');
    // }
    if (isset($posted_data['search_query'])) {
      $str = $posted_data['search_query'];
      $query = $query->where(
        function ($query) use ($str) {
          return $query
            ->where('property_units.prop_type', 'like', '%' . $str . '%')
            ->orwhere('property_units.prop_number', 'like', '%' . $str . '%');
        }
      );
    }
    if (isset($posted_data['prop_status'])) {
      $query = $query->where('property_units.prop_status', $posted_data['prop_status']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('property_units.id', 'DESC');
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

  public function saveUpdate($posted_data = array(), $where_posted_data = array()) {
    if (isset($posted_data['update_id'])) {
      $data = PropertyUnit::find($posted_data['update_id']);
    } else {
      $data = new PropertyUnit;
      $posted_data = array_filter($posted_data);
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
    if (isset($posted_data['prop_number'])) {
      $data->prop_number = $posted_data['prop_number'];
    }
    if (isset($posted_data['prop_floor'])) {
      $data->prop_floor = $posted_data['prop_floor'];
    }
    if (isset($posted_data['prop_rent'])) {
      $data->prop_rent = $posted_data['prop_rent'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = PropertyUnit::getPropertyUnit([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deletePropertyUnit($id = 0, $where_posted_data = array()) {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = PropertyUnit::find($id);
    } else {
      $data = PropertyUnit::latest();
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
