<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\ModelInterface;

class Products extends Model implements ModelInterface
{
    use HasFactory, SoftDeletes;

    protected $searchable = ['product_name'];

    protected $fillable = [
        'category_id', 'product_name'
    ];

    protected $createRules = [
        'category_id' => 'required|exists:categories,id',
        'product_name' => 'required|string'
    ];
    protected $updateRules = [
        'category_id' => 'required|exists:categories,id',
        'product_name' => 'required|string'
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

    public function category()
    {
        return $this->belongsTo(Categories::class);
    }
}
