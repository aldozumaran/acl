<?php 

namespace AldoZumaran\Acl\Traits;


trait AclSyncTrait
{
    public function syncPermission($data)
    {
        $permission = $this->where($data);
        $count = $permission->count();
        if ($count == 0){
            $this->create($data);
            return true;
        }
        if ($count == 1)
        {
            $permission->delete();
            return true;
        }
        return false;
    }
}