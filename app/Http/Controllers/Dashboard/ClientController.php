<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Client\StoreClientRequest;
use App\Http\Requests\Dashboard\Client\UpdateClientRequest;
use App\Http\Resources\ClientReousrce;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class ClientController extends Controller
{
    use Paginatable, Imageable;
    public function index()
    {
        $allServices = Client::with('media')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'clients' => ClientReousrce::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }


    public function store(StoreClientRequest $request)
    {
        //store
        $service = Client::create($request->except('image'));
        $newImage = $this->insertImage($service->name_en,$request->image,Client::PATH_IMAGE);
        $this->insertImageInMeddiable($service,$newImage,'media');

        return response()->json([
            'message' => "Ok",
            'data' => new ClientReousrce($service)
        ],Response::HTTP_CREATED);
    }


    public function show($clientId)
    {
        //show
        $service = Client::with('media')->whereId($clientId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new ClientReousrce($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateClientRequest $request, $clientId)
    {
        //update
        $service = Client::whereId($clientId)->first();
        if($service){
            $service->update($request->except('image'));
            if($request->file('image')){
                //remove old Image
                $image = $service->media()->first();
                if($image){
                    $this->deleteImage(Client::DISK_NAME,$image);
                    $service->media()->delete();
                }
                //insert New Image
                $newImage = $this->insertImage($service->name_en,$request->image,Client::PATH_IMAGE);
                $this->insertImageInMeddiable($service,$newImage,'media');
            }
            return response()->json([
                'message' => "Updated",
                'data' => new ClientReousrce($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($clientId)
    {
        //delete
        $service = Client::whereId($clientId)->first();
        if($service){
            if($service->media){
                $image = $service->media()->first();
                $this->deleteImage(Client::DISK_NAME,$image);
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
