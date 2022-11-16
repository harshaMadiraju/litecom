<?php

namespace App\Repositories;

use App\Http\Controllers\RedisController;
use Illuminate\Support\Facades\DB;


class BaseRepository
{
    public function getAllData($table, $search = NULL, $searchable = [], $conditions = [], $selects = [], $paginate = false)
    {
        $query = DB::table($table);

        if (!empty($selects)) {
            $query->select($selects);
        } else {
            $query->select('*');
        }

        if (!empty($conditions)) {
            $query->where($conditions);
        }

        if ($search) {
            $query->where(function ($q) use ($search, $searchable) {
                foreach ($searchable as $searchable) {
                    $q->orWhere($searchable, 'LIKE', '%' . $search . '%');
                }
            });
        }

        return $query->get();
    }
}
