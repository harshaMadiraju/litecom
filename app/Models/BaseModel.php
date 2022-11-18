<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BaseModel extends Model
{
    public function getAllData($input = [], $searchable)
    {
        $model = $this->newQuery();
        if ($input) {
            if (@$input['search']) {
                $model->where(function ($q) use ($input, $searchable) {
                    foreach ($searchable as $col) {
                        $q->orWhere($col, 'LIKE', '%' . $input['search'] . '%');
                    }
                });
            }
        }

        return $model->get();
    }
}
