<?php

namespace Database\Seeders;

use App\Classes\PremSeed;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table('permissions')->delete();
        DB::table('roles')->delete();
        DB::table('users')->delete();

        DB::statement('ALTER TABLE `permissions` AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE roles AUTO_INCREMENT = 1');
        DB::statement('ALTER TABLE users AUTO_INCREMENT = 1');

        PremSeed::permSeedPermissions();

        $newRole = new Role();
        $newRole->name = 'Super Admin';
        $newRole->guard_name = 'web';
        $newRole->save();

        $newUser = new User();
        $newUser->name = 'Super Admin';
        $newUser->email = 'superAdmin@gmail.com';
        $newUser->password = Hash::make('12345678');
        $newUser->save();

        $newUser->syncRoles($newRole);
    }
}
