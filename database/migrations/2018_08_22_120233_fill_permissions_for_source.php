<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FillPermissionsForSource extends Migration
{
    protected $roles;
    protected $permissions;

    public function __construct()
    {
        //New permissions
        $this->permissions = [
            ['name' => 'admin.source'],
            ['name' => 'admin.source.index'],
            ['name' => 'admin.source.create'],
            ['name' => 'admin.source.show'],
            ['name' => 'admin.source.edit'],
            ['name' => 'admin.source.delete'],
        ];

        //Role should already exists
        $this->roles = [
            [
                'name' => 'Administrator',
                'permissions' => [
                    'admin.source',
                    'admin.source.index',
                    'admin.source.create',
                    'admin.source.show',
                    'admin.source.edit',
                    'admin.source.delete',
                ],
            ],
        ];
    }

    public function up()
    {
        app()['cache']->forget('spatie.permission.cache');
        DB::transaction(function () {
            foreach ($this->permissions as $permission) {
                $permission = array_merge($permission, [
                    'guard_name' => config('auth.defaults.guard'),
                    'created_at' => \Carbon\Carbon::now(),
                    'updated_at' => \Carbon\Carbon::now(),
                ]);
                if (!($permissionItem = DB::table('permissions')->where('name', '=', $permission['name'])->first())) {
                    DB::table('permissions')->insert($permission);
                }
            }

            foreach ($this->roles as $role) {
                $permissions = $role['permissions'];
                unset($role['permissions']);

                if ($roleItem = DB::table('roles')->where('name', '=', $role['name'])->first()) {
                    $roleId = $roleItem->id;

                    $permissionItems = DB::table('permissions')->whereIn('name', $permissions)->get();
                    foreach ($permissionItems as $permissionItem) {
                        if (!($rolePermissionItem = DB::table('role_has_permissions')
                            ->where('permission_id', '=', $permissionItem->id)
                            ->where('role_id', '=', $roleId)->first())) {
                            DB::table('role_has_permissions')->insert([
                                'permission_id' => $permissionItem->id,
                                'role_id' => $roleId,
                            ]);
                        }
                    }
                }
            }
        });
    }

    public function down()
    {
        app()['cache']->forget('spatie.permission.cache');
        DB::transaction(function () {
            foreach ($this->permissions as $permission) {
                if (!empty($permissionItem = DB::table('permissions')->where('name', '=', $permission['name'])->first())) {
                    DB::table('permissions')->where('id', '=', $permissionItem->id)->delete();
                    DB::table('model_has_permissions')->where('permission_id', '=', $permissionItem->id)->delete();
                }
            }
        });
    }
}
