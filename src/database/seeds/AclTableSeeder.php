<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;
class AclTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $read = factory(App\Models\Acl\Permission::class)->create([
            'code'      => 'read',
            'name'     => 'read',
            'description'  => 'read'
        ]);
        $update = factory(App\Models\Acl\Permission::class)->create([
            'code'      => 'update',
            'name'     => 'update',
            'description'  => 'update'
        ]);
        $destroy = factory(App\Models\Acl\Permission::class)->create([
            'code'      => 'destroy',
            'name'     => 'destroy',
            'description'  => 'destroy'
        ]);
        $create = factory(App\Models\Acl\Permission::class)->create([
            'code'      => 'create',
            'name'     => 'create',
            'description'  => 'create'
        ]);
        $sadmin = factory(App\Models\Acl\Role::class)->create([
            'code'      => 'super-admin',
            'name'     => 'Super Administrator',
            'description'  => 'Super Administrator'
        ]);
        $section = factory(App\Models\Acl\Section::class)->create([
            'code'      => 'test.custom',
            'name'     => 'Test controller',
            'description'  => 'Test controller section'
        ]);

        $user = factory(Config::get('acl.user','\App\User'))->create([
            'name'      => 'John Doe',
            'email'     => 'john.doe@is.me',
            'password'  => bcrypt('doe')
        ]);
        $user->roles()->save($sadmin);
        factory(App\Models\Acl\PermissionRoleSection::class)->create([
            'permission_id' => $read->id,
            'role_id'       => $sadmin->id,
            'section_id'    => $section->id
        ]);
        factory(App\Models\Acl\PermissionRoleSection::class)->create([
            'permission_id' => $update->id,
            'role_id'       => $sadmin->id,
            'section_id'    => $section->id
        ]);
        factory(App\Models\Acl\PermissionRoleSection::class)->create([
            'permission_id' => $destroy->id,
            'role_id'       => $sadmin->id,
            'section_id'    => $section->id
        ]);

        factory(App\Models\Acl\PermissionSectionUser::class)->create([
            'permission_id' => $create->id,
            'section_id'    => $section->id,
            'user_id'       => $user->id
        ]);
    }
}
