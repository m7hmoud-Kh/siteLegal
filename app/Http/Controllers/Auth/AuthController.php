<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:8',
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
                $token = Str::random(8);
                ResetPassword::create([
                    'email' => $request->email,
                    'token' => $token,
                ]);
            }

            Mail::to($request->email)->send(new ResetPasswordEmail([
                'email' => $request->email,
                'token' => $token,
            ]));
            return 'Mail was sent, please Check Your Inbox';
        }
    }

    public function verifyToken(VerfiyTokenRequest $request)
    {
        $passwordReset = ResetPassword::where('token',$request->token)->first();
        if($passwordReset){
            return response()->json([
                'message' => $passwordReset
            ]);
        }else{
            return response()->json([
                'message' => "Code is invalid"
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function resetPassword(ResetPasswordRequest $request)
    {
        $emailFound = Admin::where('email',$request->email)->first();
        $passwordReset = ResetPassword::where('token',$request->token)->where('email',$request->email)->first();

        if($passwordReset && $emailFound){
            $emailFound->update([
                'password' => $request->password
            ]);
            //delete row reset Password
            $passwordReset->delete();
            return response()->json([
                'message' => 'Password Updated Successfully'
            ]);
        }else{
            return response()->json([
                'message' => 'Invalid Data',
            ]);
        }
    }
}
