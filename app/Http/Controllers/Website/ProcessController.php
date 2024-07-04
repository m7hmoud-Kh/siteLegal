<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProcessResource;
use App\Http\Trait\Paginatable;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class ProcessController extends Controller
{
    //
    use Paginatable;
    public function index()
    {
        $allServices = Process::status()->with('media')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'processes' => ProcessResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }

    public function show($processId)
    {
        $service = Process::status()->with('media')->whereId($processId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new ProcessResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

}
