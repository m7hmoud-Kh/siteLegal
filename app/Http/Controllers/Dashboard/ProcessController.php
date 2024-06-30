<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Process\StoreProcessRequest;
use App\Http\Requests\Dashboard\Process\UpdateProcessRequest;
use App\Http\Resources\ProcessResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Process;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class ProcessController extends Controller
{
    use Paginatable, Imageable;
    public function index()
    {
        $allServices = Process::with('media')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'processes' => ProcessResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }


    public function store(StoreProcessRequest $request)
    {
        //store
        $service = Process::create($request->except('image'));
        $newImage = $this->insertImage($service->name_en,$request->image,Process::PATH_IMAGE);
        $this->insertImageInMeddiable($service,$newImage,'media');

        return response()->json([
            'message' => "Ok",
            'data' => new ProcessResource($service)
        ],Response::HTTP_CREATED);
    }


    public function show($processId)
    {
        //show
        $service = Process::with('media')->whereId($processId)->first();
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

    public function update(UpdateProcessRequest $request, $processId)
    {
        //update
        $service = Process::whereId($processId)->first();
        if($service){
            $service->update($request->except('image'));
            if($request->file('image')){
                //remove old Image
                $image = $service->media()->first();
                if($image){
                    $this->deleteImage(Process::DISK_NAME,$image);
                    $service->media()->delete();
                }
                //insert New Image
                $newImage = $this->insertImage($service->name_en,$request->image,Process::PATH_IMAGE);
                $this->insertImageInMeddiable($service,$newImage,'media');
            }
            return response()->json([
                'message' => "Updated",
                'data' => new ProcessResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($processId)
    {
        //delete
        $service = Process::whereId($processId)->first();
        if($service){
            if($service->media){
                $image = $service->media()->first();
                $this->deleteImage(Process::DISK_NAME,$image);
                $service->media()->delete();
            }
            $service->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
