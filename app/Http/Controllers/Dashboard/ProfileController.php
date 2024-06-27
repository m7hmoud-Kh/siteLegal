<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Profile\ChangePasswordRequest;
use App\Http\Requests\Dashboard\Profile\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{

    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    public function userProfile()
    {
        $user = User::where('id', Auth::user()->id)->first();
        return response()->json([
            'Admin' => new UserResource($user)
        ]);
    }


    public function update(UpdateUserRequest $request)
    {
        $admin = User::whereId(auth()->user()->id)->first();
        $admin->update($request->all());
        return response()->json([
            'message' => 'Admin Updated Data Successfully..',
            'status' => Response::HTTP_ACCEPTED
        ],Response::HTTP_ACCEPTED);
    }


    public function changePassword(ChangePasswordRequest $request)
    {
        $user = User::find(Auth::user()->id);
        $user->update([
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'message' => 'Password Change Successfully',
            'status' => Response::HTTP_OK
        ]);
    }


}
