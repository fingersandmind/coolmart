<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FallBackController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Page Not Found. If error persists, contact info@coolmart.com'], 404);
    }
}
