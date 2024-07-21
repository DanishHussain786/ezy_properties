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
