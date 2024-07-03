<?php

/**
 *  @author  DANISH HUSSAIN <danishhussain9525@hotmail.com>
 *  @link    Author Website: https://danishhussain.w3spaces.com/
 *  @link    Author LinkedIn: https://pk.linkedin.com/in/danish-hussain-285345123
 *  @since   2020-03-01
 **/

use App\Models\User;
use Laravel\Ui\Presets\Vue;
use Carbon\Carbon;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

if (!function_exists('is_image_exist')) {
  function is_image_exist($image_path = '', $type = "image", $is_public_path = false, $inStorage = true) {
    $default_asset = ($type == "image") ? 'default-image.png' : 'default-profile-image.png';

    $local_paths_url = array('127.0.0.1', '::1');
    if (in_array($_SERVER['REMOTE_ADDR'], $local_paths_url))
      $base_url = url('/');
    else
      $base_url = url('/') . '/public';

    $asset_url = $base_url . '/app-assets/images/default-assets/' . $default_asset;

    $storagePath = '';
    if ($inStorage) {
      $storagePath = 'storage';
    }

    if ($image_path == '' || is_null($image_path)) {
      return $asset_url;
    } else if ($is_public_path && (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $image_path) || file_exists(public_path() . '/' . $image_path))) {
      return $base_url . '/' . $image_path;
    } else if (!$is_public_path && (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $storagePath . '/' . $image_path) || file_exists(public_path() . '/' . $storagePath . '/' . $image_path))) {
      return $base_url . '/' . $storagePath . '/' . $image_path;
    } else {
      return $asset_url;
    }
  }
}

if (!function_exists('upload_assets')) {
  function upload_assets($asset_data, $folder_name = false, $original = false, $optimized = false, $thumbnail = false, $inStorage = true) {
    $extension = strtolower($asset_data->getClientOriginalExtension());
    $fileName = time() . '_' . rand(1000000, 9999999) . '.' . $extension;
    $uploadfileObj = $asset_data;
    $folderName = $folder_name;

    $storagePath = '';
    if ($inStorage) {
      $storagePath = 'storage';
    }

    if ($original) {
      $destinationPath = public_path('/' . $storagePath . '/' . $folderName);
      if (!file_exists($destinationPath)) {
        mkdir($destinationPath, 0777, true);
      }
      $uploadfileObj->move($destinationPath, $fileName);
      $imagePath = $folderName . '/' . $fileName;
    }

    // if ($optimized) {
    //   $destinationPath = public_path('/' . $storagePath . '/' . $folderName . '/optimized');
    //   if (!file_exists($destinationPath)) {
    //     mkdir($destinationPath, 0777, true);
    //   }
    //   $fileObj->save($destinationPath . '/' . $fileName, 25);
    //   $imagePath = $folderName . '/optimized/' . $fileName;
    // }

    // if ($thumbnail) {
    //   $destinationPath = public_path('/' . $storagePath . '/' . $folderName . '/thumbnail');
    //   if (!file_exists($destinationPath)) {
    //     mkdir($destinationPath, 0777, true);
    //   }
    //   $fileObj->resize(200, 200, function ($constraint) {
    //     $constraint->aspectRatio();
    //   })->save($destinationPath . '/' . $fileName);
    // }

    if (isset($imagePath)) {
      return $imagePath;
    } else {
      return false;
    }
  }
}

if (!function_exists('unlink_assets')) {
  function unlink_assets($asset_path, $inStorage = true)
  {
    if (isset($asset_path)) {
      $base_url = public_path();
      $storagePath = '';
      if ($inStorage) {
        $storagePath = 'storage';
      }
      $url = $base_url . '/' . $storagePath . '/' . $asset_path;

      if (file_exists($url)) {
        unlink($url);
      }
    }
    return true;
  }
}

if (!function_exists('get_roles')) {
  function get_roles()
  {
    $roles = Config::get('constants.userRoles.all_keys_arr');
		$roles = array_filter($roles, function($role) {
			return $role !== 'Master';
		});
		
		return $roles = array_values($roles); // Reindex the array if necessary
  }
}

if (!function_exists('get_all_roles')) {
  function get_all_roles()
  {
    return $roles = Config::get('constants.userRoles.all_keys_arr');
  }
}

if (!function_exists('get_floors')) {
  function get_floors()
  {
    $floors = [];
    for ($i = 1; $i <= 100; $i++) {
      if ($i % 10 == 1 && $i != 11) {
        $floors[] = $i . 'st';
      } elseif ($i % 10 == 2 && $i != 12) {
        $floors[] = $i . 'nd';
      } elseif ($i % 10 == 3 && $i != 13) {
        $floors[] = $i . 'rd';
      } else {
        $floors[] = $i . 'th';
      }
    }

    return $floors;
  }
}

if (!function_exists('convert_timestamp_to_specific_format')) {
  function convert_timestamp_to_specific_format($time = false, $mode = '12_hour')
  {
    if (!$time) {
      return "";
    }

    $new_time = new DateTime($time);
    if ($mode == '12_hour') return $new_time->format('h:i A');
    else if ($mode == 'Y-m-d') return $new_time->format('Y-m-d');
    else if ($mode == 'm/d/Y') return $new_time->format('m/d/Y');
    else if ($mode == '12_hour_with_time') return $new_time->format('Y-m-d h:i A');
  }
}

if (!function_exists('datetime_difference')) {
  function datetime_difference($start_date, $end_date)
  {
    $date1 = new DateTime($start_date);
    $date2 = new DateTime($end_date);
    
    $diff = $date2->diff($date1);
    
    $days = $diff->days; // Total difference in days
    $hours = $diff->h + ($days * 24);
    $mins = $diff->i;
    $secs = $diff->s;
    
    return [
      'days' => $days,
      'hours' => $hours,
      'minutes' => $mins,
      'seconds' => $secs,
      'difference' => $hours . ":" . $mins . ":" . $secs,
    ];
  }
}

if (!function_exists('add_to_datetime')) {
  function add_to_datetime($datetime, $options = [])
  {
    $date = Carbon::parse($datetime);

    // Check if the options array contains specific keys and add them to the datetime
    if (isset($options['months'])) {
      $date->addMonths($options['months']);
    }
    if (isset($options['days'])) {
      $date->addDays($options['days']);
    }
    if (isset($options['hours'])) {
      $date->addHours($options['hours']);
    }

    // Return the modified datetime as a string or Carbon instance
    return $date->toDateTimeString(); // or return $date for Carbon instance
  }
}

if (!function_exists('default_value')) {
  function default_value($value, $mode = "blank")
  {
    if( (isset($value)) && $value != "") 
      return $value;
    else if ($mode == "str")  
      return "N/A";
    else if ($mode == "num")
      return 0;
    else if ($mode == "blank")
      return "";
  }
}

if (!function_exists('generate_unique_numeric_id')) {
  function generate_unique_numeric_id()
  {
    // It will always return a 9 digit unique string
    return floor(time()-999999999);
  }
}

if (!function_exists('generate_random_key')) {
  function generate_random_key($keyLength = 5)
  {
    // Characters to be used in the key
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    
    // Set a blank variable to store the key
    $key = '';
    
    for ($x = 0; $x < $keyLength; $x++) {
      // Append a random character from the character set
      $key .= $characters[random_int(0, $charactersLength - 1)];
    }
    
    return $key;
  }
}

if (!function_exists('get_label_class')) {
  function get_label_class($status = "")
  {
    if ($status == 'Pre-Reserve') return $label_class = "label-warning";
    else if ($status == 'Reserved') return $label_class = "label-primary";
    else if ($status == 'Checked-In') return $label_class = "label-custom";
    else if ($status == 'Checked-Out') return $label_class = "label-info";
    else if ($status == 'Over-Stay') return $label_class = "label-danger";
    else if ($status == 'Maintenance') return $label_class = "label-default";
    else return $label_class = "label-success";
  }
}

if (!function_exists('get_comma_seperated_strings')) {
  function get_comma_seperated_strings($array = array(), $get_keys = false)
  {
    $array_str = "";

    if (count($array) > 0) {
      foreach ($array as $key => $value) {
        // Check if user wants to use keys instead of values
        if ($get_keys) {
          $array_str .= $key . ",";
        } else {
          if ($value != "") {
            $array_str .= $value . ",";
          }
        }
      }
      // Remove the trailing comma
      $array_str = rtrim($array_str, ",");
    }

    return $array_str;
  }
}