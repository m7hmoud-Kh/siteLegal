<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Manager\ManagerStoreRequest;
use App\Http\Requests\Dashboard\Manager\ManagerUpdateRequest;
use App\Http\Resources\UserResource;
use App\Http\Trait\Paginatable;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;

class ManagerController extends Controller
{

    use Paginatable;

    public function index()
    {
        $allAdmins = User::role(['admin','supervisor'])
        // ->whereId('!=',Auth::guard('admin')->user()->id)
        ->latest()
        ->paginate();
        return response()->json([
            'Status' => Response::HTTP_OK,
            'data' => UserResource::collection($allAdmins),
            'meta' => $this->getPaginatable($allAdmins)
        ]);
    }


    public function show($managerId)
    {
        $manager = User::whereId($managerId)->role(['admin','supervisor'])->first();
        if($manager){
            return response()->json([
                'message' => "Ok",
                'data' => new UserResource($manager)
            ]);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ]);
        }
    }


    public function store(ManagerStoreRequest $request)
    {
        $user = User::create(array_merge($request->except('role','password_confirmation'),[
            'password' => Hash::make($request->password)
        ]));
        $user->assignRole($request->role);
        return response()->json([
            'message' => "Ok",
            'data' => new UserResource($user)
        ],Response::HTTP_CREATED);
    }

    public function update(ManagerUpdateRequest $request, $managerId)
    {
        $user = User::whereId($managerId)->role(['admin','supervisor'])->first();
        if($user){
            $user->update($request->except('role'));
            if($request->role){
                $user->syncRoles([$request->role]);
            }
            return response()->json([
                'message' => "Updated",
                'data' => new UserResource($user)
            ],Response::HTTP_ACCEPTED);
        }else{
            return response()->json([
                'message' => 'Not Found'
            ]);
        }
    }

    public function destory($managerId)
    {
        $user = User::whereId($managerId)->role(['admin','supervisor'])->first();
        if($user){
            $user->delete();
            return response()->json([],Response::HTTP_NO_CONTENT);
        }else{
            return response()->json([
                'message' => 'Not Found Or not Allow to Remove It'
            ]);
        }
    }
}
