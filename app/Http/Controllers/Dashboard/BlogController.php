<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Blog\StoreBlogRequest;
use App\Http\Requests\Dashboard\Blog\UpdateBlogRequest;
use App\Http\Resources\BlogResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class BlogController extends Controller
{
    use Paginatable, Imageable;
    public function index()
    {
        $allServices = Blog::with('media')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'services' => BlogResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }


    public function store(StoreBlogRequest $request)
    {
        //store
        $service = Blog::create($request->except('image'));
        $newImage = $this->insertImage($service->name_en,$request->image,Blog::PATH_IMAGE);
        $this->insertImageInMeddiable($service,$newImage,'media');

        return response()->json([
            'Message' => "Ok",
            'data' => new BlogResource($service)
        ],Response::HTTP_CREATED);
    }


    public function show($blogId)
    {
        //show
        $service = Blog::with('media')->whereId($blogId)->first();
        if($service){
            return response()->json([
                'Message' => "Ok",
                'data' => new BlogResource($service)
            ]);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function update(UpdateBlogRequest $request, $blogId)
    {
        //update
        $service = Blog::whereId($blogId)->first();
        if($service){
            $service->update($request->except('image'));
            if($request->file('image')){
                //remove old Image
                $image = $service->media()->first();
                if($image){
                    $this->deleteImage(Blog::DISK_NAME,$image);
                    $service->media()->delete();
                }
                //insert New Image
                $newImage = $this->insertImage($service->name_en,$request->image,Blog::PATH_IMAGE);
                $this->insertImageInMeddiable($service,$newImage,'media');
            }
            return response()->json([
                'Message' => "Updated",
                'data' => new BlogResource($service)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'Message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($blogId)
    {
        //delete
        $service = Blog::whereId($blogId)->first();
        if($service){
            if($service->media){
                $image = $service->media()->first();
                $this->deleteImage(Blog::DISK_NAME,$image);
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
