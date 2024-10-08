<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class Service extends Model
{
  use HasFactory, SoftDeletes;
  protected $table = 'services';

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
  //   return $this->hasMany(ServiceInformation::class, 'user_id', 'id')->with('skill_data')
  //     ->where([
  //         ['info_status', '=' ,'Skill'],
  //     ])->select(['id', 'user_id', 'info_status', 'skill_id', 'created_at', 'updated_at']);
  // }

  public function getService($posted_data = array())
  {
    $columns = ['services.*'];
    $select_columns = array_merge($columns, []);
    $query = Service::latest();

    if (isset($posted_data['relations']) && $posted_data['relations']) {
      $query = $query->with('booked_by_user')
        ->with('booked_for_user')
        ->with('property_data');
    }

    if (isset($posted_data['id'])) {
      $query = $query->where('services.id', $posted_data['id']);
    }
    if (isset($posted_data['title'])) {
      $query = $query->where('services.title', 'like', '%' . $posted_data['title'] . '%');
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('services.id', 'DESC');
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

  public function saveUpdateService($posted_data = array(), $where_posted_data = array())
  {
    $posted_data = array_filter($posted_data);
    if (isset($posted_data['update_id'])) {
      $data = Service::find($posted_data['update_id']);
    } else {
      $data = new Service;
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

    if (isset($posted_data['title'])) {
      $data->title = $posted_data['title'];
    }
    if (isset($posted_data['charges'])) {
      $data->charges = $posted_data['charges'];
    }
    if (isset($posted_data['type'])) {
      $data->type = $posted_data['type'];
    }
    if (isset($posted_data['deleted_at'])) {
      $data->deleted_at = $posted_data['deleted_at'];
    }
    $data->save();

    $data = Service::getService([
      'detail' => true,
      'id' => $data->id
    ]);
    return $data;
  }

  public function deleteService($id = 0, $where_posted_data = array())
  {
    $is_deleted = false;
    if ($id > 0) {
      $is_deleted = true;
      $data = Service::find($id);
    } else {
      $data = Service::latest();
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
