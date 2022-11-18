<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class RolesAccesses extends BaseModel implements ModelInterface
{
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'role_id', 'module', 'methods_allowed', 'status', 'created_at', 'updated_at'
    ];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $searchable = ['role'];

    protected $createRules = [
        'role' => 'required|string'
    ];

    protected $updateRules = [
        'role_id' => 'required|integer|exists:roles,id',
        'module' => 'required|string',
        'methods_allowed' => 'required|in:get,post,put,patch,delete',
        'status' => 'required|in:A,I'
    ];

    public function roles()
    {
        return $this->belongsTo(Roles::class);
    }

    public function accessModules()
    {
        return $this->belongsTo(AccessModules::class);
    }

    public function getCreateRules()
    {
        return $this->createRules;
    }

    public function getUpdateRules()
    {
        return $this->updateRules;
    }

    public function getSearchable()
    {
        return $this->searchable;
    }
}
