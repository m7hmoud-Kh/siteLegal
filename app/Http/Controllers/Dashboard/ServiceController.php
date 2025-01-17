<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Service\StoreServiceRequest;
use App\Http\Requests\Dashboard\Service\UpdateServiceRequest;
use App\Http\Resources\ServiceResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;
use Serializable;

class ServiceController extends Controller
{
    use Paginatable, Imageable;
    public function index()
    {
        $allServices = Service::with('media')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'services' => ServiceResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }


    public function store(StoreServiceRequest $request)
    {
        //store
        $service = Service::create($request->except('image'));
        $newImage = $this->insertImage($service->name_en,$request->image,Service::PATH_IMAGE);
        $this->insertImageInMeddiable($service,$newImage,'media');

        return response()->json([
            'message' => "Ok",
            'data' => new ServiceResource($service)
        ],Response::HTTP_CREATED);
    }

    public function showGroupInSelection()
    {
        $allService = Service::Status()->latest()->get(['id','name_en']);
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => $allService
        ]);
    }
    public function show($serviceId)
    {
        //show
        $service = Service::with('media')->whereId($serviceId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new ServiceResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateServiceRequest $request, $serviceId)
    {
        //update
        $service = Service::whereId($serviceId)->first();
        if($service){
            $service->update($request->except('image'));
            if($request->file('image')){
                //remove old Image
                $image = $service->media()->first();
                if($image){
                    $this->deleteImage(Service::DISK_NAME,$image);
                    $service->media()->delete();
                }
                //insert New Image
                $newImage = $this->insertImage($service->name_en,$request->image,Service::PATH_IMAGE);
                $this->insertImageInMeddiable($service,$newImage,'media');
            }
            return response()->json([
                'message' => "Updated",
                'data' => new ServiceResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($serviceId)
    {
        //delete
        $service = Service::whereId($serviceId)->first();
        if($service){
            if($service->media){
                $image = $service->media()->first();
                $this->deleteImage(Service::DISK_NAME,$image);
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
