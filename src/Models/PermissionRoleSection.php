<?php

namespace App\Models\Acl;

use Illuminate\Database\Eloquent\Model;
use AldoZumaran\Acl\Traits\AclSyncTrait;

class PermissionRoleSection extends Model
{
    use AclSyncTrait;

    protected $fillable = [
        'role_id', 'section_id', 'permission_id',
    ];
    public function permission()
    {
        return $this->belongsTo('App\Models\Acl\Permission');
    }
    public function role()
    {
        return $this->belongsTo('App\Models\Acl\Role');
    }
    public function section()
    {
        return $this->belongsTo('App\Models\Acl\Section');
    }
}
