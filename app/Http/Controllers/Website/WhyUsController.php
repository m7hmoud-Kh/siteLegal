<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\WhyUsResource;
use App\Models\WhyUs;
use Illuminate\Http\Request;

class WhyUsController extends Controller
{
    public function index()
    {
        $allServices = WhyUs::Status()->latest()->get();
        return response()->json([
            'whyus' => WhyUsResource::collection($allServices),
        ]);
    }
}
