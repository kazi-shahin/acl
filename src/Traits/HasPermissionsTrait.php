<?php
namespace KaziShahin\Acl\Traits;

use KaziShahin\Acl\Models\PermissionModel;
use KaziShahin\Acl\Models\RoleModel;

trait HasPermissionsTrait {

    /**
     * roles
     */
    public function roles() {
        return $this->belongsToMany(RoleModel::class,'user_roles', 'user_id', 'role_id');
    }

    /**
     * permissions
     */
    public function permissions() {
        return $this->belongsToMany(PermissionModel::class,'user_permissions', 'user_id', 'permission_id');
    }

    /**
     * rolePermissions
     */
    public function rolePermissions() {
        return $this->belongsToMany(PermissionModel::class,'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * hasRole
     */
    public function hasRole($roles ) {
        foreach ($roles as $role) {
            $collections = $this->roles;
            $exists = $collections->contains('name', $role->name);
            if ($exists) return true;
            continue;
        }
        return false;
    }

    /**
     * hasPermissionThroughRole
     */
    public function hasPermissionThroughRole($permission)
    {
        foreach($permission->roles as $role) {
            if($this->roles->contains($role)) return true;
        }
        return false;
    }

    /**
     * hasPermissionTo
     */
    public function hasPermissionTo($permission)
    {
        return $this->hasPermissionThroughRole($permission) || (bool) $this->permissions->where('name',$permission->name)->count();
    }

}
