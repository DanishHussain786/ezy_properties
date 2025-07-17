<?php

// config/constants.php
return [
  'booking_logs' => [
    /* ALL COLUMNS
      'id','booking_id','property_id','service_id','checkin_date','checkout_date','for_days','for_months','rent','disc_rent','markup_rent','charge_rent','purpose','status','deleted_at','created_at','updated_at'
    */
    'id','booking_id','property_id','service_id','checkin_date','checkout_date','for_days','for_months','rent','disc_rent','markup_rent','charge_rent','purpose','status','created_at'
  ],
  'properties' => [
    /* ALL COLUMNS
      'id','prop_type','unit_number','unit_floor','unit_rent','other_charges','dewa_charges','wifi_charges','misc_charges','prop_net_rent','prop_address','prop_status','deleted_at','created_at','updated_at'
    */
    'id','prop_type','unit_number','unit_floor','unit_rent','other_charges','dewa_charges','wifi_charges','misc_charges','prop_net_rent','prop_address','prop_status','created_at'
  ],
  'users' => [
    /* ALL COLUMNS
      'id','first_name','last_name','gender','status','role','dob','contact_no','whatsapp_no','profile_photo','home_address','email','emirates_id','emirates_photo','passport_id','passport_photo','password','remember_token','email_verified_at','deleted_at','created_at','updated_at'
    */
    'id','first_name','last_name','role','contact_no','whatsapp_no','profile_photo','email'
  ]
];
