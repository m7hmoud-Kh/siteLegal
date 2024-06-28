<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Section\StoreSectionRequest;
use App\Http\Requests\Dashboard\Section\UpdateSectionRequest;
use App\Http\Resources\SectionResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Section;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class SectionController extends Controller
{
    use Paginatable, Imageable;
    public function index()
    {
        $allServices = Section::with('media','service')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'services' => SectionResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }


    public function store(StoreSectionRequest $request)
    {
        //store
        $service = Section::create($request->except('image'));
        $newImage = $this->insertImage($service->name_en,$request->image,Section::PATH_IMAGE);
        $this->insertImageInMeddiable($service,$newImage,'media');

        return response()->json([
            'Message' => "Ok",
            'data' => new SectionResource($service)
        ],Response::HTTP_CREATED);
    }

    public function show($secitonId)
    {
        //show
        $service = Section::with('media')->whereId($secitonId)->first();
        if($service){
            return response()->json([
                'Message' => "Ok",
                'data' => new SectionResource($service)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateSectionRequest $request, $secitonId)
    {
        //update
        $service = Section::whereId($secitonId)->first();
        if($service){
            $service->update($request->except('image'));
            if($request->file('image')){
                //remove old Image
                $image = $service->media()->first();
                if($image){
                    $this->deleteImage(Section::DISK_NAME,$image);
                    $service->media()->delete();
                }
                //insert New Image
                $newImage = $this->insertImage($service->name_en,$request->image,Section::PATH_IMAGE);
                $this->insertImageInMeddiable($service,$newImage,'media');
            }
            return response()->json([
                'Message' => "Updated",
                'data' => new SectionResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($sectionId)
    {
        //delete
        $service = Section::whereId($sectionId)->first();
        if($service){
            if($service->media){
                $image = $service->media()->first();
                $this->deleteImage(Section::DISK_NAME,$image);
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
