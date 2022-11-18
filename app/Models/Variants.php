<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variants extends BaseModel implements ModelInterface
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['product_id', 'name', 'value', 'created_at', 'updated_at'];

    protected $hidden = ['created_at', 'updated_at', 'deleted_at'];

    protected $searchable = ['name'];

    protected $createRules = [
        'product_id' => 'required|exists:products,id',
        'name' => 'required|string',
        'value' => 'required|string'
    ];

    protected $updateRules = [
        'name' => 'required|string',
        'value' => 'required|string'
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

    public function product()
    {
        return $this->belongsTo(Products::class);
    }
}
