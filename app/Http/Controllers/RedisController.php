<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public static function find($table, $selects = [], $conditions = [], $orderBy = [], $limit = NULL, $type = "get")
    {

        $redisKey = self::prepareRedisKey($table, $selects, $conditions, $orderBy, $limit, $type);

        $cacheData = Redis::get($redisKey);

        if (isset($cacheData) && !empty($cacheData)) {
            return json_decode($cacheData, true);
        } else {
            $query = DB::table($table)->select($selects);
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
            if (!empty($orderBy)) {
                foreach ($orderBy as $key => $value) {
                    $query->orderBy($key, $value);
                }
            }

            if (!empty($limit)) {
                $query->limit($limit);
            }

            if ($type = "first")
                $data = $query->first();
            else
                $data = $query->get();

            if ($data) {
                Redis::set($redisKey, json_encode($data));
            }

            return $data;
        }
    }

    public static function prepareRedisKey($table, $selects = [], $conditions = [], $orderBy = [], $limit = NULL, $type = "get")
    {

        $redisKey = $table . ":" . implode(",", $selects) . ":";
        foreach ($conditions as $key => $value) {
            $redisKey .= $key . "=" . $value . ";";
        }
        $redisKey .= ":";
        if (!empty($orderBy)) {
            foreach ($orderBy as $key => $value) {
                $redisKey .= "orderBy" . $key . "=" . $value . ";";
            }
        }

        if (!empty($limit)) {
            $redisKey .= "limit=" . $limit;
        }

        $redisKey .= ":" . $type;

        return $redisKey;
    }
}
