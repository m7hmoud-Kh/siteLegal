<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Http\Resources\ServiceResource;
use App\Models\Section;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ServiceController extends Controller
{
    //
    public function index()
    {
        $allServices = Service::with('media')->Status()->latest()->get();
        return response()->json([
            'services' => ServiceResource::collection($allServices),
        ]);
    }

    public function getAllSectionBasedOnServiceId(Request $request)
    {
        $service = Service::with(['sections' => function($q){
            return $q->status()->with('media');
        },'media'])
        ->whereId($request->serviceId)
        ->Status()
        ->latest()
        ->first();
        if($service){
            return response()->json([
                'service' => new ServiceResource($service)
            ]);
        }
        return response()->json([
            'message' => 'Not Found'
        ],Response::HTTP_BAD_REQUEST);

    }

    public function getSectionById(Request $request)
    {
        $section = Section::status()->with('media')->whereId($request->sectionId)->first();
        if($section){
            return response()->json([
                'message' => new SectionResource($section)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
