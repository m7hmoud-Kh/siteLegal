<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ServiceResource;
use App\Http\Trait\Paginatable;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

class ServiceController extends Controller
{
    //
    use Paginatable;
    public function index()
    {
        $allServices = Service::Status()->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'services' => ServiceResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }
}