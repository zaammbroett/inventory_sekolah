<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Inventory Sekolah API",
 *     version="1.0.0",
 *     description="API Dokumentasi Inventory Sekolah"
 * )
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local Server"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}