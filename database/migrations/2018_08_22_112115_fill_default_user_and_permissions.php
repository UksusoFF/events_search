<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class FillDefaultUserAndPermissions extends Migration
{
    protected $roles;
    protected $permissions;

    public function __construct()
    {
        $defaultPermissions = collect([
            // view admin as a whole
            'admin',

            // manage translations
            'admin.translation.index',
            'admin.translation.edit',
            'admin.translation.rescan',

            // manage users (access)
            'admin.user.index',
            'admin.user.create',
            'admin.user.edit',
            'admin.user.delete',

            // ability to upload
            'admin.upload',
        ]);

        //Add new teams
        $this->permissions = $defaultPermissions->map(function ($permission) {
            return [
                'name' => $permission,
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ];
        })->toArray();

        //Add new teams
        $this->roles = [
            [
                'name' => 'Administrator',
                'guard_name' => config('auth.defaults.guard'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
                'permissions' => $defaultPermissions,
            ],
        ];
    }

    public function up()
    {
        DB::transaction(function () {
            foreach ($this->permissions as $permission) {
                DB::table('permissions')->insert($permission);
            }

            foreach ($this->roles as $role) {
                $permissions = $role['permissions'];
                unset($role['permissions']);

                $roleId = DB::table('roles')->insertGetId($role);

                $permissionItems = DB::table('permissions')->whereIn('name', $permissions)->get();
                foreach ($permissionItems as $permissionItem) {
                    DB::table('role_has_permissions')->insert([
                        'permission_id' => $permissionItem->id,
                        'role_id' => $roleId,
                    ]);
                }
            }

            foreach (DB::table('users')->get() as $user) {
                $roleItems = DB::table('roles')->whereIn('name', [
                    'Administrator',
                ])->get();
                foreach ($roleItems as $roleItem) {
                    DB::table('model_has_roles')->insert([
                        'role_id' => $roleItem->id,
                        'model_id' => $user->id,
                        'model_type' => 'App\Models\User',
                    ]);
                }
            }
        });
    }

    public function down()
    {
        DB::transaction(function () {
            DB::table('model_has_permissions')->where('model_type', '=', 'App\Models\User')->delete();
            DB::table('model_has_roles')->where('model_type', '=', 'App\Models\User')->delete();

            foreach ($this->roles as $role) {
                if (!empty($roleItem = DB::table('roles')->where('name', '=', $role['name'])->first())) {
                    DB::table('roles')->where('id', '=', $roleItem->id)->delete();
                    DB::table('model_has_roles')->where('role_id', '=', $roleItem->id)->delete();
                }
            }

            foreach ($this->permissions as $permission) {
                if (!empty($permissionItem = DB::table('permissions')->where('name', '=', $permission['name'])->first())) {
                    DB::table('permissions')->where('id', '=', $permissionItem->id)->delete();
                    DB::table('model_has_permissions')->where('permission_id', '=', $permissionItem->id)->delete();
                }
            }
        });
    }
}
