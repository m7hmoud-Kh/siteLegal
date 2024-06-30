<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ClientReousrce;
use App\Http\Trait\Paginatable;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $allServices = Client::with('media')->status()->latest()->get();
        return response()->json([
            'clients' => ClientReousrce::collection($allServices),
        ]);
    }
}
