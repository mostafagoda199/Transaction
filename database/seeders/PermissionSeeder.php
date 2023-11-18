<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use ReflectionException;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws ReflectionException
     */
    public function run(): void
    {
        $permissionsWithCategories = get_permission_from_public_methods_controller();

        foreach ($permissionsWithCategories as $category => $permissions) {
            $categoryName =  str_replace('-', ' ', Str::kebab($category));

            foreach ($permissions as $permission) {
                $permissionKey = Str::snake($category) . '-' . $permission;
                $permissionName = Str::snake($category) . '-' . trans('message.permissions.'.$permission);
                Permission::query()->firstOrCreate([
                    'group_key' => $categoryName,
                    'name' => $permissionName,
                    'key' => $permissionKey
                ]);
            }
        }
    }
}
