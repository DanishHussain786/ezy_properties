<?php

namespace Database\Seeders;

use DB;
use Exception;
use Illuminate\Database\Seeder;

class PropertySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            if (DB::table('properties')->count() == 0) {
                DB::table('properties')->insert([
                    [
                        'prop_type' => 'Villa',
                        'prop_number' => '514',
                        'prop_floor' => '1st',
                        'prop_rent' => '2500',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Appartment',
                        'prop_number' => '33',
                        'prop_floor' => '2nd',
                        'prop_rent' => '201',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Pre-Reserve',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Studio',
                        'prop_number' => '305',
                        'prop_floor' => '3rd',
                        'prop_rent' => '5500',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Reserved',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Room',
                        'prop_number' => '422',
                        'prop_floor' => '4th',
                        'prop_rent' => '675',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Checked-In',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Room',
                        'prop_number' => '333',
                        'prop_floor' => '13th',
                        'prop_rent' => '680',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Checked-Out',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Room',
                        'prop_number' => '1205',
                        'prop_floor' => '12th',
                        'prop_rent' => '650',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Over-Stay',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Room',
                        'prop_number' => '905',
                        'prop_floor' => '9th',
                        'prop_rent' => '450',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Maintenance',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Villa',
                        'prop_number' => '52',
                        'prop_floor' => '2nd',
                        'prop_rent' => '5500',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                        'prop_type' => 'Appartment',
                        'prop_number' => '313',
                        'prop_floor' => '5th',
                        'prop_rent' => '2500',
                        'prop_address' => 'Oval Towers, Business Bay, Suite',
                        'status' => 'Available',
                        'created_at' => now(),
                        'updated_at' => now(),
                    ],
                    [
                      'prop_type' => 'Room',
                      'prop_number' => '109',
                      'prop_floor' => '1st',
                      'prop_rent' => '550',
                      'prop_address' => 'Oval Towers, Business Bay, Suite',
                      'status' => 'Available',
                      'created_at' => now(),
                      'updated_at' => now(),
                  ],
                  [
                      'prop_type' => 'Room',
                      'prop_number' => '705',
                      'prop_floor' => '7th',
                      'prop_rent' => '675',
                      'prop_address' => 'Oval Towers, Business Bay, Suite',
                      'status' => 'Available',
                      'created_at' => now(),
                      'updated_at' => now(),
                  ],
                  [
                      'prop_type' => 'Room',
                      'prop_number' => '955',
                      'prop_floor' => '8th',
                      'prop_rent' => '950',
                      'prop_address' => 'Oval Towers, Business Bay, Suite',
                      'status' => 'Available',
                      'created_at' => now(),
                      'updated_at' => now(),
                  ],
                ]);
            } else {
                echo "[Property Table is not empty]\n";
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
}
