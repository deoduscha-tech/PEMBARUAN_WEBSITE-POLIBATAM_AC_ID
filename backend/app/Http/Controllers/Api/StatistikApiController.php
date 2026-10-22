<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class StatistikApiController extends Controller
{
    public function index(): JsonResponse
    {
        $path = resource_path('data/statistik.php');
        $data = is_file($path) ? require $path : [];

        return response()->json(['data' => $data]);
    }
}
