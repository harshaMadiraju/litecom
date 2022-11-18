<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends BaseModel implements ModelInterface
{
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'role', 'status', 'created_at', 'updated_at'
    ];

    protected $searchable = ['role'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $createRules = [
        'role' => 'required|string'
    ];

    protected $updateRules = [
        'role' => 'required|string'
    ];

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
