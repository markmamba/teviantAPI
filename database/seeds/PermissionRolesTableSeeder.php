<?php

use Illuminate\Database\Seeder;

class PermissionRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permission_roles')->delete();

        // Set permissions for the Super User role
        $super_user_permissions = DB::table('permissions')->get();
        $super_user_role        = DB::table('roles')->where('name', 'Super User')->first();
        foreach ($super_user_permissions as $permission) {
            $super_user_permissionRoles[] = [
                'permission_id' => $permission->id,
                'role_id'       => $super_user_role->id,
            ];
        }

        // Set permissions for the Adminitrator role
        $administrator_permissions = DB::table('permissions')
            ->where('name', 'not like', 'roles%')
            ->where('name', 'not like', 'permissions%')
            ->get();
        $administrator_role = DB::table('roles')->where('name', 'Administrator')->first();
        foreach ($administrator_permissions as $permission) {
            $administrator_permissionRoles[] = [
                'permission_id' => $permission->id,
                'role_id'       => $administrator_role->id,
            ];
        }

        // Set permissions for the Inbound Operator role
        $inbound_operator_permissions = DB::table('permissions')
            ->where('name', 'like', 'purchase_orders%')
            ->orWhere('name', 'like', 'receivings%')
            ->get();
        $inbound_operator_role = DB::table('roles')->where('name', 'Inbound Operator')->first();
        foreach ($inbound_operator_permissions as $permission) {
            $inbound_operator_permissionRoles[] = [
                'permission_id' => $permission->id,
                'role_id'       => $inbound_operator_role->id,
            ];
        }

        // Set permissions for the Outbound Operator role
        $outbound_operator_permissions = DB::table('permissions')
            ->where('name', 'like', 'orders%')
            ->get();
        $outbound_operator_role = DB::table('roles')->where('name', 'Outbound Operator')->first();
        foreach ($outbound_operator_permissions as $permission) {
            $outbound_operator_permissionRoles[] = [
                'permission_id' => $permission->id,
                'role_id'       => $outbound_operator_role->id
            ];
        }

        // Insert to the database.
        DB::table('permission_roles')->insert(array_merge(
            $super_user_permissionRoles,
            $administrator_permissionRoles,
            $inbound_operator_permissionRoles,
            $outbound_operator_permissionRoles
        ));
    }
}
