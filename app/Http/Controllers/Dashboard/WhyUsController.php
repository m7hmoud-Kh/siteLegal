<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WhyUs\StoreWhyUsRequest;
use App\Http\Requests\Dashboard\WhyUs\UpdateWhyUsRequest;
use App\Http\Resources\WhyUsResource;
use App\Http\Trait\Paginatable;
use App\Models\WhyUs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class WhyUsController extends Controller
{
    use Paginatable;
    public function index()
    {
        $allWhyUs = WhyUs::latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'faqs' => WhyUsResource::collection($allWhyUs),
            'meta' => $this->getPaginatable($allWhyUs),
        ]);
    }

    public function store(StoreWhyUsRequest $request)
    {
        //store
        $service = WhyUs::create($request->validated());
        return response()->json([
            'message' => "Ok",
            'data' => new WhyUsResource($service)
        ],Response::HTTP_CREATED);
    }


    public function show($whyUsId)
    {
        //show
        $service = WhyUs::whereId($whyUsId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new WhyUsResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateWhyUsRequest $request, $whyUsId)
    {
        //update
        $service = WhyUs::whereId($whyUsId)->first();
        if($service){
            $service->update($request->validated());
            return response()->json([
                'message' => "Updated",
                'data' => new WhyUsResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($whyUsId)
    {
        //delete
        $service = WhyUs::whereId($whyUsId)->first();
        if($service){
            $service->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
