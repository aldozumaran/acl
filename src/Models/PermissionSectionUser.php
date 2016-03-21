<?php

namespace App\Models\Acl;

use Illuminate\Database\Eloquent\Model;

use AldoZumaran\Acl\Traits\AclSyncTrait;

class PermissionSectionUser extends Model
{
    use AclSyncTrait;

    protected $fillable = [
        'user_id', 'section_id', 'permission_id',
    ];
    public function permission()
    {
        return $this->belongsTo('App\Models\Acl\Permission');
    }
    public function section()
    {
        return $this->belongsTo('App\Models\Acl\Section');
    }
    public function user()
    {
        return $this->belongsTo('App\Models\Acl\User');
    }
}
