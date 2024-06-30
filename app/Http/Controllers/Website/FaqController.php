<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $allServices = Faq::status()->latest()->get();
        return response()->json([
            'faqs' => FaqResource::collection($allServices),
        ]);
    }
}
