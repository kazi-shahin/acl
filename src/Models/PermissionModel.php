<?php

namespace KaziShahin\Acl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PermissionModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permissions';

    protected $fillable = [
        'name', 'details' , 'type'
    ];

    public function roles() {
        return $this->belongsToMany(RoleModel::class,'role_permissions', 'permission_id', 'role_id');
    }

    /**
     * Get permission Details ById
     */
    public function getPermissionDetailsById($id, $getRelationData = true){
        $query = $this->where("id", $id);
        if($getRelationData) $query = $query->permissionRelations();
        return $query->first();
    }

    /**
     * Get permission Lists
     */
    public function getPermissions($request){
        return $this->ofSearch($request)->ofOrder($request)->ofPaginate($request);
    }


    /**
     * Search
     */
    public function scopeOfSearch($query, $request){
        $search = isset($request['search'])? $request['search']: "";
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%')
                    ->orWhere('details', 'LIKE', '%' . $search . '%')
                    ->orWhere('type', 'LIKE', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Relations
     */
    public function scopePermissionRelations($query){
        return $query->with("roles");
    }
}
