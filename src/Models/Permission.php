<?php

namespace App\Models\Acl;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'code', 'name', 'description',
    ];
    public function permissionsRolesSections()
    {
        return $this->hasMany('App\Models\Acl\PermissionRoleSection');
    }
    public function permissionsSectionsUsers()
    {
        return $this->hasMany('App\Models\Acl\PermissionSectionUser');
    }
}
