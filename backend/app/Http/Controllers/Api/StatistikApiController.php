<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use App\Support\SiteContentRepository;

class StatistikApiController extends Controller
{
    public function __construct(private SiteContentRepository $content) {}

    public function index(): JsonResponse
    {
        return response()->json(['data' => $this->content->get('statistik', [])]);
    }
}
