<?php

namespace App\Classes;

use Spatie\Permission\Models\Permission;

class PremSeed
{
    public static $permissionsArray = [

        // dashboard
        'dashboard_view' => [
            'name' => 'dashboard_view',
            'display_name' => 'Dashboard View',
            'guard_name' => 'web',
        ],
        //articles permissions
        'articles_create' => [
            'name' => 'articles_create',
            'display_name' => 'Articles Create',
            'guard_name' => 'web',
        ],
        'articles_view' => [
            'name' => 'articles_view',
            'display_name' => 'Articles View',
            'guard_name' => 'web',
        ],
        'articles_update' => [
            'name' => 'articles_update',
            'display_name' => 'Articles Update',
            'guard_name' => 'web',
        ],
        'articles_delete' => [
            'name' => 'articles_delete',
            'display_name' => 'Articles Delete',
            'guard_name' => 'web',
        ],
        // users permissions
        'users_create' => [
            'name' => 'users_create',
            'display_name' => 'Users Create',
            'guard_name' => 'web',
        ],
        'users_view' => [
            'name' => 'users_view',
            'display_name' => 'Users View',
            'guard_name' => 'web',
        ],
        'users_update' => [
            'name' => 'users_update',
            'display_name' => 'Users Update',
            'guard_name' => 'web',
        ],
        'users_delete' => [
            'name' => 'users_delete',
            'display_name' => 'Users Delete',
            'guard_name' => 'web',
        ],

        //roles permissions
        'roles_create' => [
            'name' => 'roles_create',
            'display_name' => 'Roles Create',
            'guard_name' => 'web',
        ],
        'roles_view' => [
            'name' => 'roles_view',
            'display_name' => 'Roles View',
            'guard_name' => 'web',
        ],
        'roles_update' => [
            'name' => 'roles_update',
            'display_name' => 'Roles Update',
            'guard_name' => 'web',
        ],
        'roles_delete' => [
            'name' => 'roles_delete',
            'display_name' => 'Roles Delete',
            'guard_name' => 'web',
        ],

        //categories permissions
        'categories_create' => [
            'name' => 'categories_create',
            'display_name' => 'Categories Create',
            'guard_name' => 'web',
        ],
        'categories _view' => [
            'name' => 'categories_view',
            'display_name' => 'Categories View',
            'guard_name' => 'web',
        ],
        'categories_update' => [
            'name' => 'categories_update',
            'display_name' => 'Categories Update',
            'guard_name' => 'web',
        ],
        'categories_delete' => [
            'name' => 'categories_delete',
            'display_name' => 'Categories Delete',
            'guard_name' => 'web',
        ],

        //payments permissions
        'payments_create' => [
            'name' => 'payments_create',
            'display_name' => 'Payments Create',
            'guard_name' => 'web',
        ],
        'payments_view' => [
            'name' => 'payments_view',
            'display_name' => 'Payments View',
            'guard_name' => 'web',
        ],
        'payments_update' => [
            'name' => 'payments_update',
            'display_name' => 'Payments Update',
            'guard_name' => 'web',
        ],
        'payments_delete' => [
            'name' => 'payments_delete',
            'display_name' => 'Payments Delete',
            'guard_name' => 'web',
        ],

        //permissions permissions

        'permissions_create' => [
            'name' => 'permissions_create',
            'display_name' => 'Permissions Create',
            'guard_name' => 'web',
        ],
        'permissions_view' => [
            'name' => 'permissions_view',
            'display_name' => 'Permissions View',
            'guard_name' => 'web',
        ],
        'permissions_update' => [
            'name' => 'permissions_update',
            'display_name' => 'Permissions Update',
            'guard_name' => 'web',
        ],
        'permissions_delete' => [
            'name' => 'permissions_delete',
            'display_name' => 'Permissions Delete',
            'guard_name' => 'web',
        ],

    ];

    public static function getPermissionsArray()
    {
        return self::$permissionsArray;
    }

    public static function permSeedPermissions()
    {
        $permissions = self::getPermissionsArray();
        foreach ($permissions as $permission) {

            $ifExist = Permission::where('name', $permission['name'])->first();
            if (!$ifExist) {
                $newPermission = new Permission();
                $newPermission->name = $permission['name'];
                $newPermission->display_name = $permission['display_name'];
                $newPermission->guard_name = $permission['guard_name'];
                $newPermission->save();
            }
        }
    }
}
