<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Roles extends Model {
    use SoftDeletes;

    protected $guarded = [];

    protected $fillable = [
        'role', 'status', 'created_at', 'updated_at'
    ];
}