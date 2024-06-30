<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Faq\StoreFaqRequest;
use App\Http\Requests\Dashboard\Faq\UpdateFaqRequest;
use App\Http\Resources\FaqResource;
use App\Http\Trait\Paginatable;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class FaqController extends Controller
{
    use Paginatable;
    public function index()
    {
        $allServices = Faq::latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'faqs' => FaqResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }

    public function store(StoreFaqRequest $request)
    {
        //store
        $service = Faq::create($request->validated());
        return response()->json([
            'message' => "Ok",
            'data' => new FaqResource($service)
        ],Response::HTTP_CREATED);
    }


    public function show($faqId)
    {
        //show
        $service = Faq::whereId($faqId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new FaqResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateFaqRequest $request, $faqId)
    {
        //update
        $service = Faq::whereId($faqId)->first();
        if($service){
            $service->update($request->validated());
            return response()->json([
                'message' => "Updated",
                'data' => new FaqResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($faqId)
    {
        //delete
        $service = Faq::whereId($faqId)->first();
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
