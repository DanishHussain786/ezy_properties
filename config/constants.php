<?php
return [
  'FIREBASE_SERVER_API_KEY' => 'AAAABPufVF0:APA91bFj7Seatse9vhu2RiRgFY6kWCnF2TqXki7y0I8IaLFtjG5ayj-_9cXHCDzVj-mNM5Gk6DT2TFS9jH_pBAeKROYzZ-f2FWu90edDJUneGFmf_4XNBuIF4FEOH2YaTbUup_O0MPo5',
  'google_map_api' => '',
  'regexPatterns' => [
    'Full_Name' => [
      'regex' => '/^[a-zA-Z]{2,}(?: [a-zA-Z]+){0,2}$/u', // first name must have min 2 chars and full_name can be upto three words
      'error' => 'Only alphabets are allowed for first, middle and last name',
    ],
    'Only_Alphabets' => [
      'regex' => '/^[a-zA-Z]+$/u', // only lower and upper case letters
      'error' => 'Only alphabets are allowed',
    ],
    'Phone_USA' => [
      'regex' => '/^\d{3}-\d{3}-\d{4}$/', // valid phone number in this format XXX-XXX-XXXX
      'error' => 'Please post a valid format (XXX-XXX-XXXX)',
    ],
    'Phone_UAE' => [
      'regex' => '/^971\d{9}$/', // valid phone number in this format 971XXXXXXXXXX
      'error' => 'Please post a valid format (971XXXXXXXXX)',
    ],
    'Password' => [
      'regex' => '/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\x])(?=.*[!$#%@^&*()_+]).*$/', // atleast eight characters long, atleast one letter, number and special character
      'error' => 'Password must be atleast eight characters long, atleast one letter, number and special character.',
    ],
    'Decimal' => [
      'regex' => '/^(([0-9]*)(\.([0-9]+))?)$/', // validate a decimal number upto 9 digits
      'error' => 'Please post a valid decimal integer',
    ],
  ],
  'userStatus' => [
    'data' => [
      'Active' => 'Active',
      'Block' => 'Block',
    ],
    'all_keys_str' => 'Active,Block',
    'all_keys_arr' => ['Active', 'Block'],
    'error' => 'Please post a valid value (Active or Block)',
  ],
  'userGender' => [
    'data' => [
      'Male' => 'Male',
      'Female' => 'Female',
    ],
    'all_keys_str' => 'Male,Female',
    'all_keys_arr' => ['Male', 'Female'],
    'error' => 'Please post a valid value (Male or Female)',
  ],
  'image' => [
    'data' => [
      'jpg' => 'jpg',
      'jpeg' => 'jpeg',
      'png' => 'png',
    ],
    'all_keys_str' => 'jpg,jpeg,png',
    'all_keys_arr' => ['jpg', 'jpeg', 'png'],
    'error' => 'Please post a valid file (jpg,jpeg or png)',
  ],
  // 'video' => [
  //   'data' => [
  //     'mp4' => 'mp4',
  //     'mov' => 'mov',
  //     'mpeg' => 'mpeg',
  //     'avi' => 'avi',
  //   ],
  //   'all_keys_str' => 'mp4,mov,mpeg,avi',
  //   'all_keys_arr' => ['mp4', 'mov', 'mpeg', 'avi'],
  //   'error' => 'Please post a valid file (mp4,mov, mpeg or avi)',
  // ],
  'userRoles' => [
    'data' => [
      'Master' => 'Master',
      'Manager' => 'Manager',
      'Agent' => 'Agent',
      'Staff' => 'Staff',
      'Customer' => 'Customer',
    ],
    'all_keys_str' => 'Master,Manager,Agent,Staff,Customer',
    'all_keys_arr' => ['Master', 'Manager','Agent','Staff','Customer'],
    'error' => 'Please post a valid value (Manager,Agent,Staff or Customer)',
  ],
  'propertyTypes' => [
    'data' => [
      'Villa' => 'Villa',
      'Appartment' => 'Appartment',
      'Studio' => 'Studio',
      'Room' => 'Room',
      'Bed Space' => 'Bed Space',
    ],
    'all_keys_str' => 'Villa,Appartment,Studio,Room,Bed Space',
    'all_keys_arr' => ['Villa', 'Appartment','Studio','Room','Bed Space'],
    'error' => 'Please post a valid value (Appartment,Studio,Room or Bed Space)',
  ],
  // 'paymentModes' => [
  //   'data' => [
  //     'Card' => 'Card',
  //     'Bank' => 'Bank',
  //     'Cash' => 'Cash',
  //   ],
  //   'all_keys_str' => 'Card,Bank,Cash',
  //   'all_keys_arr' => ['Card', 'Bank', 'Cash'],
  //   'error' => 'Please post a valid value (Card,Bank or Cash)',
  // ],
];
