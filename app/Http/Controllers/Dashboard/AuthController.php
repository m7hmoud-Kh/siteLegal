<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\Auth\ResetPasswordRequest;
use App\Http\Resources\UserResource;
use App\Mail\ResetPasswordEmail;
use App\Models\ResetPassword;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(),400);
        }
        if (!$token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }


    protected function createNewToken($token)
    {
        $user = User::where('id', Auth::user()->id)->first();
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 50000,
            'user' => new UserResource($user)
        ]);
    }

    public function sendEmail(Request $request)
    {
        $emailFound = User::whereEmail($request->email)->first();
        if($emailFound){
            //get old token if found
            $oldToken = ResetPassword::whereEmail($request->email)->first();
            if($oldToken){
                $token = $oldToken->token;
            }else{
                $token = Str::random(40);
                ResetPassword::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);
            }

            Mail::to($request->email)->send(new ResetPasswordEmail([
                'email' => $request->email,
                'token' => $token,
            ]));
            return response()->json([
                'message' => 'Mail was sent, please Check Your Inbox'
            ]);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $passwordReset = ResetPassword::where('token',$request->token)->first();
        if($passwordReset){
            $message = $this->reset($passwordReset,$request);
            return response()->json([
                'message' => $message
            ]);
        }
    }

    private function reset($passwordReset,$request){
        $emailFound = User::whereEmail($passwordReset->email)->first();
        if($emailFound){
            $emailFound->update([
                'password' => Hash::make($request->password),
            ]);
            //delete row reset Password
            $passwordReset->delete();
            return 'Password Updated Successfully';
        }else{
            return response()->json([
                'message' => 'Data invalid'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
