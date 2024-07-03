<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Setting\UpdateSettingRequest;
use App\Http\Resources\SettingResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class SettingController extends Controller
{
    use Paginatable, Imageable;
    public function index()
    {
        $allServices = Setting::with('media')->paginate(Config::get('app.per_page'));
        return response()->json([
            'settings' => SettingResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }

    public function show($settingId)
    {
        //show
        $service = Setting::with('media')->whereId($settingId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new SettingResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateSettingRequest $request, $settingId)
    {
        //update
        $service = Setting::with('media')->whereId($settingId)->first();
        if($service){
            if($request->file('image')){
                //remove old Image
                $image = $service->media()->first();
                if($image){
                    $this->deleteImage(Setting::DISK_NAME,$image);
                    $service->media()->delete();
                }
                //insert New Image
                $newImage = $this->insertImage($service->value,$request->image,Setting::PATH_IMAGE);
                $this->insertImageInMeddiable($service,$newImage,'media');
            }
            $service->update($request->except('image'));
            return response()->json([
                'message' => "Updated",
                'data' => new SettingResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

}
