<?php

namespace AldoZumaran\Acl\Traits;

use App\Models\Acl\Permission;
use App\Models\Acl\PermissionSectionUser;
use App\Models\Acl\Role;
use App\Models\Acl\Section;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

trait AclUserTrait
{
    public function cachedPermissionsSectionsUsers()
    {
        $PrimaryKey = $this->primaryKey;
        $cacheKey = 'acl_permission_section_users_'.$this->$PrimaryKey;

        return Cache::tags('permission_section_users')->remember($cacheKey, Config::get('cache.ttl'), function () {
            return $this->where('id', $this->id)->with('permissionsSectionsUsers.permission', 'permissionsSectionsUsers.section')->first()->permissionsSectionsUsers;
        });
    }

    public function cachedRoles()
    {
        $PrimaryKey = $this->primaryKey;
        $cacheKey = 'acl_roles_'.$this->$PrimaryKey;
        return Cache::tags('role_user')->remember($cacheKey, Config::get('cache.ttl'), function () {
            return $this->roles()->get();
        });
    }

    public function save(array $options = [])
    {   //both inserts and updates
        parent::save($options);
        Cache::tags('permission_section_users')->flush();
        Cache::tags('role_user')->flush();
    }

    public function delete(array $options = [])
    {   //soft or hard
        parent::delete($options);
        Cache::tags('permission_section_users')->flush();
        Cache::tags('role_user')->flush();
    }

    public function restore()
    {   //soft delete undo's
        parent::restore();
        Cache::tags('permission_section_users')->flush();
        Cache::tags('role_user')->flush();
    }

    public function permissionsSectionsUsers()
    {
        return $this->hasMany('App\Models\Acl\PermissionSectionUser');
    }

    public function roles()
    {
        return $this->belongsToMany('App\Models\Acl\Role');
    }

    public function hasRole($name, $requireAll = false)
    {
        if (is_array($name)) {
            foreach ($name as $roleName) {
                $hasRole = $this->hasRole($roleName);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->roles as $role) {
                if ($role->code == $name) {
                    return true;
                }
            }
        }

        return false;
    }

    public function hasUserPermission($section, $perm, $requireAll = false)
    {
        if (is_array($perm)) {
            foreach ($perm as $permission) {
                $hasRole = $this->hasUserPermission($section,$permission);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedPermissionsSectionsUsers() as $pivot) {
                if ( 
                    $pivot->section->code == $section &&  
                    $pivot->permission->code == $perm && 
                    $pivot->user_id == $this->id 
                    )
                    return true;
            }
        }

        return false;
    }
    public function hasRolePermission($section, $perm, $requireAll = false)
    {
        if (is_array($perm)) {
            foreach ($perm as $permission) {
                $hasRole = $this->hasRolePermission($section,$permission);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedRoles() as $role) {
                if ( $role->hasPermission($section, $perm) )
                    return true;
            }
        }

        return false;
    }

    public function hasPermission($section, $perm, $requireAll = false)
    {
        if (is_array($perm)) {
            foreach ($perm as $permission) {
                $hasRole = $this->hasRolePermission($section,$permission, $requireAll);
                if (!$hasRole)
                    $hasRole = $this->hasUserPermission($section,$permission, $requireAll);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            if ($hasRole = $this->hasRolePermission($section,$perm, $requireAll))
                return true;
            elseif ($hasRole = $this->hasuserPermission($section,$perm, $requireAll))
                return true;
        }

        return false;
    }

    public function attachPerm( $section, $permission )
    {

        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        elseif (is_array($permission)) {
            $permission = $permission['id'];
        }elseif (intval($permission) == 0) {
            $permission = Permission::where('code',$permission)->first()->id;
        }

        if (is_object($section)) {
            $section = $section->getKey();
        }
        elseif (is_array($permission)) {
            $section = $section['id'];
        }elseif (is_string($section)) {
            $section = Section::where('code',$section)->first()->id;
        }

        if (Permission::where('id',$permission)->count() == 0 || Section::where('id',$section)->count() == 0)
            return false;

        $data = [
            'user_id' => $this->id,
            'section_id' => $section,
            'permission_id' => $permission,
        ];

        $permission = PermissionSectionUser::where($data);
        if ($permission->count() == 0) {
            PermissionSectionUser::create($data);
            return true;
        }
        return false;
    }
    public function detachPerm( $section, $permission )
    {

        if (is_object($permission)) {
            $permission = $permission->getKey();
        }
        elseif (is_array($permission)) {
            $permission = $permission['id'];
        }elseif (is_string($permission)) {
            $permission = Permission::where('code',$permission)->first()->id;
        }

        if (is_object($section)) {
            $section = $section->getKey();
        }
        elseif (is_array($section)) {
            $section = $section['id'];
        }elseif (intval($permission) == 0) {
            $section = Section::where('code',$section)->first()->id;
        }

        if (!$permission || !$section)
            return false;

        $data = [
            'user_id' => $this->id,
            'section_id' => $section,
            'permission_id' => $permission,
        ];

        $permission = PermissionSectionUser::where($data);
        if ($permission->count() == 1){
            $permission->delete();
            return true;
        }

        return false;
    }
}
