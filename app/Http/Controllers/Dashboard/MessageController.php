<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Resources\MessageResource;
use App\Http\Trait\Imageable;
use App\Http\Trait\Paginatable;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class MessageController extends Controller
{
    //
    use Paginatable;

    public function index()
    {
        $allServices = Message::latest()->paginate(Config::get('app.per_page'));
        return response()->json([
            'messages' => MessageResource::collection($allServices),
            'meta' => $this->getPaginatable($allServices),
        ]);
    }


    public function show($messageId)
    {
        //show
        $service = Message::whereId($messageId)->first();
        if($service){
            return response()->json([
                'messsage' => "Ok",
                'data' => new MessageResource($service)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ],Response::HTTP_BAD_REQUEST);
        }
    }

    public function destory($messageId)
    {
        //delete
        $service = Message::whereId($messageId)->first();
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
