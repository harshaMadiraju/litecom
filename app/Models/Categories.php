<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['id', 'category_name', 'created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $searchable = ['category_name'];

    protected $createRules = [
        'category_name' => 'required|string'
    ];

    protected $updateRules = [
        'category_name' => 'required|string'
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

    public function products()
    {
        return $this->hasMany(Products::class);
    }
}
