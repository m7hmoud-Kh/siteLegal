<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\BlogResource;
use App\Http\Trait\Paginatable;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class BlogController extends Controller
{
    use Paginatable;
    public function index()
    {
        $allServices = Blog::status()->with('media')->latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'blogs' => BlogResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }

    public function show($blogId)
    {
        //show
        $service = Blog::status()->with('media')->whereId($blogId)->first();
        if($service){
            return response()->json([
                'message' => "Ok",
                'data' => new BlogResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

}
