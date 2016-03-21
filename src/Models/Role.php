<?php

namespace App\Models\Acl;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'code', 'name', 'description',
    ];

    public function permissionsRolesSections()
    {
        return $this->hasMany('App\Models\Acl\PermissionRoleSection');
    }

    public function cachedPermissionsRolesSections()
    {
        $PrimaryKey = $this->primaryKey;
        $cacheKey = 'acl_permission_role_sestions_'.$this->$PrimaryKey;
        return Cache::tags('permission_role_sestions')->remember($cacheKey, Config::get('cache.ttl'), function () {
            return $this->where('id',$this->id)->with('permissionsRolesSections.permission', 'permissionsRolesSections.section')->first()->permissionsRolesSections;
        });
    }
    public function users()
    {
        return $this->belongsToMany('App\Models\Auth\User');
    }

    public function save(array $options = [])
    {   //both inserts and updates
        parent::save($options);
        Cache::tags('permission_role_sestions')->flush();
    }

    public function delete(array $options = [])
    {   //soft or hard
        parent::delete($options);
        Cache::tags('permission_role_sestions')->flush();
    }

    public function restore()
    {   //soft delete undo's
        parent::restore();
        Cache::tags('permission_role_sestions')->flush();
    }

    public function hasPermission($section, $perm, $requireAll = false)
    {
        if (is_array($perm)) {
            foreach ($perm as $permission) {
                $hasRole = $this->hasPermission($section,$permission);

                if ($hasRole && !$requireAll) {
                    return true;
                } elseif (!$hasRole && $requireAll) {
                    return false;
                }
            }

            return $requireAll;
        } else {
            foreach ($this->cachedPermissionsRolesSections() as $pivot) {
                if ( 
                    $pivot->section->code == $section &&  
                    $pivot->permission->code == $perm && 
                    $pivot->role_id == $this->id 
                    )
                    return true;
            }
        }

        return false;
    }
}
