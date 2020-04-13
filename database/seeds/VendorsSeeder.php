<?php

use Illuminate\Database\Seeder;
use App\Models\Vendor;
use App\Models\User;

class VendorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Models\Vendor', 20)->create();
        Vendor::all()->each(function($vendor){
            factory('App\Models\Product', 20)->create([
                'vendor_id' => $vendor->id
            ]);
        });
    }
}
