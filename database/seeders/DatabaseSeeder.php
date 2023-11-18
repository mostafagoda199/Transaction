<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class
        ]);

        $customerRole = Role::factory()->create([
             'name'=>'customer',
             'slug'=>'customer',
         ]);

        $transactionsPermissions = Permission::where(['group_key' => 'transaction'])->get()->keyBy('key');
        $customerRole->permissions()->attach($transactionsPermissions->get('transaction-index')->id);

        $adminRole = Role::factory()->create([
             'name'=>'admin',
             'slug'=>'admin',
         ]);
        $adminRole->permissions()->attach($transactionsPermissions->pluck('id'));


        User::factory(10)->create();

        User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role_id' => $adminRole->id
        ]);

        User::factory()->create([
            'name' => 'Guest User',
            'email' => 'customer@example.com',
            'role_id' => $customerRole->id
        ]);
    }
}
