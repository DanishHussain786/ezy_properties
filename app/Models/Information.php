<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Information extends Model
{
  use HasFactory;
  protected $table = 'informations';

  public function getInformation($posted_data = array())
  {
    $columns = ['informations.*'];
    $select_columns = array_merge($columns, []);
    $query = Information::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      // $query = $query->with('booked_by_user')
      //   ->with('booked_for_user')
      //   ->with('property_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('informations.id', $posted_data['id']);
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

    if (isset($posted_data['c_name'])) {
      $data->c_name = $posted_data['c_name'];
    }
    if (isset($posted_data['c_email'])) {
      $data->c_email = $posted_data['c_email'];
    }
    if (isset($posted_data['c_office_ph'])) {
      $data->c_office_ph = $posted_data['c_office_ph'];
    }
    if (isset($posted_data['c_mobile_ph'])) {
      $data->c_mobile_ph = $posted_data['c_mobile_ph'];
    }
    if (isset($posted_data['c_address'])) {
      $data->c_address = $posted_data['c_address'];
    }
    if (isset($posted_data['c_logo'])) {
      $data->c_logo = $posted_data['c_logo'];
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
