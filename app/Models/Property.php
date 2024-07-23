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

  /**
   * The attributes that are mass assignable.
   *
   * @var array<int, string>
   */
  protected $fillable = [
    // 'name',
    // 'email',
    // 'password',
  ];

  /**
   * The attributes that should be hidden for serialization.
   *
   * @var array<int, string>
   */
  protected $hidden = [
    'password',
    'remember_token',
  ];

  /**
   * The attributes that should be cast.
   *
   * @var array<string, string>
   */
  protected $casts = [
    'email_verified_at' => 'datetime',
    'password' => 'hashed',
  ];

  // public function skills() {
  //   return $this->hasMany(PropertyInformation::class, 'user_id', 'id')->with('skill_data')
  //     ->where([
  //         ['info_status', '=' ,'Skill'],
  //     ])->select(['id', 'user_id', 'info_status', 'skill_id', 'created_at', 'updated_at']);
  // }

  public function getProperty($posted_data = array())
  {
    $columns = ['users.*'];
    $select_columns = array_merge($columns, []);
    $query = Property::latest();

    // if (isset($posted_data['without_with']) && $posted_data['without_with']) {
    // } else {
      // $query = $query;
        // ->with('skills')
        // ->with('profile_reviews');
    // }

    if (isset($posted_data['id'])) {
      $query = $query->where('users.id', $posted_data['id']);
      $posted_data['detail'] = true;
    }
    if (isset($posted_data['first_name'])) {
      $query = $query->where('users.first_name', 'like', '%' . $posted_data['first_name'] . '%');
    }
    if (isset($posted_data['last_name'])) {
      $query = $query->where('users.last_name', 'like', '%' . $posted_data['last_name'] . '%');
    }
    if (isset($posted_data['search_user'])) {
      $str = $posted_data['search_user'];
      if ($str == trim($str) && strpos($str, ' ') !== false) {
        $query = $query->where(
          function ($query) use ($str) {
            $str_ary = explode(' ', $str);
            return $query
              ->where('users.first_name', 'like', '%' . $str_ary[0] . '%')
              ->orwhere('users.last_name', 'like', '%' . $str_ary[1] . '%');
          }
        );
      }
      else {
        $query = $query->where(
          function ($query) use ($str) {
            return $query
              ->where('users.first_name', 'like', '%' . $str . '%')
              ->orwhere('users.last_name', 'like', '%' . $str . '%');
          }
        );
      }
    }
    if (isset($posted_data['status'])) {
      $query = $query->where('users.status', $posted_data['status']);
    }

    $query->getQuery()->orders = null;
    if (isset($posted_data['orderBy_name']) && isset($posted_data['orderBy_value'])) {
      $query->orderBy($posted_data['orderBy_name'], $posted_data['orderBy_value']);
    } else {
      $query->orderBy('users.id', 'DESC');
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

    if (isset($posted_data['first_name'])) {
      $data->first_name = ucwords($posted_data['first_name']);
    }
    if (isset($posted_data['last_name'])) {
      $data->last_name = ucwords($posted_data['last_name']);
    }
    if (isset($posted_data['gender'])) {
      $data->gender = $posted_data['gender'];
    }
    if (isset($posted_data['status'])) {
      $data->status = $posted_data['status'];
    }
    if (isset($posted_data['role'])) {
      $data->role = $posted_data['role'];
    }
    if (isset($posted_data['dob'])) {
      $data->dob = $posted_data['dob'];
    }
    if (isset($posted_data['contact_no'])) {
      $data->contact_no = $posted_data['contact_no'];
    }
    if (isset($posted_data['whatsapp_no'])) {
      $data->whatsapp_no = $posted_data['whatsapp_no'];
    }
    if (isset($posted_data['profile_photo'])) {
      $data->profile_photo = $posted_data['profile_photo'];
    }
    if (isset($posted_data['home_address'])) {
      $data->home_address = $posted_data['home_address'];
    }
    if (isset($posted_data['email'])) {
      $data->email = $posted_data['email'];
    }
    if (isset($posted_data['emirates_id'])) {
      $data->emirates_id = $posted_data['emirates_id'];
    }
    if (isset($posted_data['emirates_photo'])) {
      $data->emirates_photo = $posted_data['emirates_photo'];
    }
    if (isset($posted_data['passport_id'])) {
      $data->passport_id = $posted_data['passport_id'];
    }
    if (isset($posted_data['passport_photo'])) {
      $data->passport_photo = $posted_data['passport_photo'];
    }
    if (isset($posted_data['password'])) {
      $data->password = Hash::make($posted_data['password']);
    }
    if (isset($posted_data['email_verified_at'])) {
      $data->email_verified_at = $posted_data['email_verified_at'];
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
