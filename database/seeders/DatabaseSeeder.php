<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        \App\Models\Roles::truncate();
        \App\Models\Roles::create([
            'role' => 'Admin',
            'status' => 'A'
        ]);
        \App\Models\Roles::create([
            'role' => 'User',
            'status' => 'A'
        ]);

        \App\Models\User::truncate();
        \App\Models\User::create([
            'name'    => 'Harsha Vardhan',
            'username'    => 'harsha3889@gmail.com',
            'password'    => app('hash')->make('12345'),
            'role_id' => 2,
        ]);

        \App\Models\RolesAccesses::truncate();
        \App\Models\RolesAccesses::create([
            'role_id' => 2,
            'module' => 'products',
            'methods_allowed' => 'get',
            'status' => 'A'
        ]);
        \App\Models\RolesAccesses::create([
            'role_id' => 2,
            'module' => 'categories',
            'methods_allowed' => 'get',
            'status' => 'A'
        ]);
        \App\Models\RolesAccesses::create([
            'role_id' => 2,
            'module' => 'variants',
            'methods_allowed' => 'get',
            'status' => 'A'
        ]);

        \App\Models\RolesAccesses::create([
            'role_id' => 1,
            'module' => 'products',
            'methods_allowed' => 'get,post,put,patch,delete',
            'status' => 'A'
        ]);
        \App\Models\RolesAccesses::create([
            'role_id' => 1,
            'module' => 'categories',
            'methods_allowed' => 'get,post,put,patch,delete',
            'status' => 'A'
        ]);
        \App\Models\RolesAccesses::create([
            'role_id' => 1,
            'module' => 'variants',
            'methods_allowed' => 'get,post,put,patch,delete',
            'status' => 'A'
        ]);

        \App\Models\Categories::truncate();
        \App\Models\Categories::factory(10)->create();

        \App\Models\Products::truncate();
        \App\Models\Products::factory(10)->create();

        \App\Models\Variants::truncate();
        \App\Models\Variants::factory(10)->create();

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
