<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request)
    {
        //store
        $service = Message::create($request->validated());
        return response()->json([
            'message' => "Ok",
            'data' => new MessageResource($service)
        ],Response::HTTP_CREATED);
    }
}
