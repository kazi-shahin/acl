<?php

namespace KaziShahin\Acl\Helpers;

use KaziShahin\Acl\Models\PermissionModel;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;

class AclHelper
{
    protected $user;

    /**
     *   Auth User
     */
    public function user()
    {
        try {
            $logged_user = Auth::user();
        } catch (QueryException $e) {
            $logged_user = collect();
        }
        return $logged_user;
    }

    /***
     * Permission
     */
    public static function getPermissions()
    {
        try {
            $permissions = PermissionModel::with("roles")->get();
        } catch (QueryException $e) {
            $permissions = collect();
        }

        return $permissions;
    }
}
