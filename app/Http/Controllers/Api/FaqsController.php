<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Faq;
use App\Http\Resources\FaqsResource;

class FaqsController extends Controller
{
    public function index()
    {
        $faqs = Faq::get();

        return new FaqsResource($faqs);
    }
}
