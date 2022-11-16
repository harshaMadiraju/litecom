<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 *  * @OA\Info(
 *   title="Laravel API Template",
 *   version="1.0",
 *   description="This is an API that scrape data users and serve the data in JSON format",
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="apiKey",
 *     in="header",
 *     name="Authorization"
 * )
 * Class Controller
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
