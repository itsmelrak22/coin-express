<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin; 

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "name" => "super admin",
                "email" => "super@cointradeexpress.com",
                "phone" => NULL,
                "never_admin" => 2,
                "is_agent" => 1,
                "invitation_code" => NULL,
                "password" => bcrypt("password"),
            ],
          
        ];
        Admin::insert($data);
        
    }
}
