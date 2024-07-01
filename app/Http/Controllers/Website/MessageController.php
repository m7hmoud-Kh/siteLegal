<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\StoreMessageRequest;
use App\Http\Resources\MessageResource;
use App\Models\Message;
use App\Models\User;
use App\Notifications\MessageNotification;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MessageController extends Controller
{
    public function store(StoreMessageRequest $request)
    {
        //
        $allAdmin = User::all();
        $message = Message::create($request->validated());
        foreach ($allAdmin as $admin) {
            $admin->notify(new MessageNotification($message));
        }
        return response()->json([
            'message' => "Ok",
            'data' => new MessageResource($message)
        ],Response::HTTP_CREATED);
    }


}
