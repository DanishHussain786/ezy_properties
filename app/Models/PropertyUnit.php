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
    'unit_type',
    'unit_number',
    'unit_floor',
    'unit_rent',
  ];

  // public function reservations_data() {
  // return $this->hasOne(Booking::class, 'property_id');
  // ->where([
  //   ['status', '=', 'Reservation']
  // ]);
  // }

  public function property() {
    return $this->belongsTo(Property::class, 'property_id', 'id');
  }

  public function getPropertyUnit($posted_data = array()) {
    $select_columns = ['property_units.*'];

    if (!empty($posted_data['select_columns']))
      $select_columns = array_merge($posted_data['select_columns'], []); // Add the specific columns

    $query = PropertyUnit::latest();

    if (!empty($posted_data['few_relations']))
      self::few_relations($posted_data);
    if (!empty($posted_data['relations']))
      self::relations($posted_data);

    foreach ($posted_data as $key => $value) {
      if (str_starts_with($key, 'with_') && !str_ends_with($key, '_columns') && $value) {
        $relation = substr($key, 5); // remove "with_" from key
        $columnsKey = "with_{$relation}_columns";

        $query->with([$relation => function ($q) use ($posted_data, $columnsKey) {
          if (!empty($posted_data[$columnsKey])) {
            $q->select($posted_data[$columnsKey]);
          }
        }]);
      }
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
            ->orwhere('property_units.unit_number', 'like', '%' . $str . '%');
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
    if (isset($posted_data['unit_type'])) {
      $data->unit_type = $posted_data['unit_type'];
    }
    if (isset($posted_data['unit_number'])) {
      $data->unit_number = $posted_data['unit_number'];
    }
    if (isset($posted_data['unit_floor'])) {
      $data->unit_floor = $posted_data['unit_floor'];
    }
    if (isset($posted_data['unit_rent'])) {
      $data->unit_rent = $posted_data['unit_rent'];
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

  public static function few_relations(&$posted_data = array()) {
    $relations_rr['with_property'] = true;
    $relations_rr['with_property_columns'] = ['id','prop_title','prop_title','prop_type'];
    // $relations_rr['with_company_business_type'] = true;
    // $relations_rr['with_company_business_type_columns'] = ['id', 'title'];
    // $relations_rr['with_company_strength'] = true;
    // $relations_rr['with_company_strength_columns'] = ['id', 'title'];
    $posted_data = array_merge($posted_data, $relations_rr);
  }

  public static function relations(&$posted_data = array()) {
    self::few_relations($posted_data);
    // $relations_rr['with_company_benefit'] = true;
    // $relations_rr['with_company_benefit_columns'] = ['id', 'company_id', 'benefit', 'image', 'description'];
    // $relations_rr['with_company_subscriber'] = true;
    // $relations_rr['with_company_subscriber_columns'] = ['id', 'company_id', 'user_id'];
    // $relations_rr['with_jobs'] = true;
    // $relations_rr['with_jobs_columns'] = ['id', 'company_id', 'title', 'post_date', 'status'];
    // $relations_rr['with_company_industries'] = true;
    // $relations_rr['with_company_industries_columns'] = ['id', 'company_id', 'industry_id'];
    // $relations_rr['with_company_skills'] = true;
    // $relations_rr['with_company_skills_columns'] = ['id', 'skill', 'company_id'];
    $posted_data = array_merge($posted_data, $relations_rr);
  }
}
