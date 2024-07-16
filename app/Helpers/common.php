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
      $storagePath = 'storage/';
    }

    if ($image_path == '' || is_null($image_path)) {
      return $asset_url;
    } else if ($is_public_path && (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $image_path) || file_exists(public_path() . '/' . $image_path))) {
      return $base_url . '/' . $image_path;
    } else if (!$is_public_path && (file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $storagePath . '' . $image_path) || file_exists(public_path() . '/' . $storagePath . '' . $image_path))) {
      return $base_url . '/' . $storagePath . '' . $image_path;
    } else {
      return $asset_url;
    }
  }
}