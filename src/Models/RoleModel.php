<?php

namespace KaziShahin\Acl\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoleModel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'roles';

    protected $fillable = [
        'name', 'created_by', 'updated_by'
    ];

    public function permissions() {
        return $this->belongsToMany(PermissionModel::class,'role_permissions', 'role_id', 'permission_id');
    }

    /**
     * Get Details ById
     */
    public function getRoleDetailsById($id, $getRelationData = true){
        $query = $this->where("id", $id);
        if($getRelationData) $query = $query->roleRelations();
        return $query->first();
    }

    /**
     * Get Lists
     */
    public function getRoles($request){
        return $this->roleRelations()->ofSearch($request)->ofOrder($request)->ofPaginate($request);
    }

    /**
     * Search
     */
    public function scopeOfSearch($query, $request){
        $search = isset($request['search'])? $request['search']: "";
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', '%' . $search . '%');
            });
        }
        return $query;
    }

    /**
     * Relations
     */
    public function scopeRoleRelations($query){
        return $query->with("permissions");
    }
}
