<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Enums\RBAC;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        try {
            DB::beginTransaction();
            $adminRole = Role::findOrCreate(RBAC::Admin->value);
            $operatorRole = Role::findOrCreate(RBAC::Operator->value);
            $specialistRole = Role::findOrCreate(RBAC::Specialist->value);
            Permission::findOrCreate('create user');
            Permission::findOrCreate('show user');
            Permission::findOrCreate('show users');
            Permission::findOrCreate('assign role');
            // Operator permissions
            Permission::findOrCreate('create complaint');
            Permission::findOrCreate('view complaints');
            Permission::findOrCreate('search complaints');
            // Specialist Back Office permissions
            Permission::findOrCreate('create complaint');
            Permission::findOrCreate('view complaints');
            Permission::findOrCreate('edit complaint');
            Permission::findOrCreate('add comment to complaint');
            Permission::findOrCreate('search complaints');
            $adminRole->syncPermissions(['create user', 'assign role', 'show user', 'show users']);
            $operatorRole->syncPermissions(['create complaint', 'view complaints', 'search complaints']);

            $specialistRole->syncPermissions([
                'create complaint',
                'view complaints',
                'edit complaint',
                'add comment to complaint',
                'search complaints',
            ]);
            if (!User::where('login', 'admin')->first()) {
                $user = User::factory()->create([
                    'name' => 'Admin User',
                    'login' => 'admin',
                    'email' => 'admin@megafon.tj',
                    'password' => bcrypt('password'),
                ]);
                $user->assignRole($adminRole);
            }


            DB::commit();

        } catch (\Exception $exception) {
            echo $exception->getMessage();
            DB::rollBack();
        }
        echo 'seed done';


    }
}
