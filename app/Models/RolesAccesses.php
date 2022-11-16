<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RolesAccesses extends Model {
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'role_id', 'access_modules_id', 'status', 'created_at', 'updated_at'
    ];

    public function roles() {
        return $this->belongsTo(Roles::class);
    }

    public function accessModules() {
        return $this->belongsTo(AccessModules::class);
    }
}