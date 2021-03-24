<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    static $roles = [
        "admin",
        "tutor",
        "user"
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach(self::$roles as $role) {
            Role::create(['name' => $role]);
        }
    }
}
