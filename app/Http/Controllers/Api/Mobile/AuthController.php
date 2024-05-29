<?php

namespace App\Http\Controllers\Api\Mobile;

use App\Admin;
use App\Http\Controllers\Controller;
use App\TokenManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => ['required'],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 400,
                'message' => 'Login failed!',
                'errors' => $validator->errors()
            ],400);
        }
        $admin = Admin::where('username',$request->username)->first();
        if(empty($admin)){
            return response()->json([
                'status' => 400,
                'message' => 'Login failed, please ceck username & password!',
            ],400);
        }
        if(!Hash::check($request->password,$admin->password)){
            return response()->json([
                'status' => 400,
                'message' => 'Login failed, please ceck username & password!',
            ],400);
        }
        $token = $this->generate_token($admin, 80);
        $response = [
            'id' => $admin->id,
            'username' => $admin->username,
            'email' => $admin->email,
            'authorization' => 'Authorization',
            'token' => $token->access_token
        ];
        return response()->json([
            'status' => 200,
            'data' => $response
        ],200);
    }

    protected function generate_token($data, $length)
    {
        $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $generated_token = substr(str_shuffle(str_repeat($string, $length)), 0, $length);
    	$expired = date('Y-m-d H:i:s', strtotime('+1 day'));
    	$token = TokenManagement::create([
            "created_by" => $data->id,
            "access_token" => $generated_token,
            "expired_at" => $expired,
            "active" => 1
        ]);
    	return $token;
    }

    public function logout(Request $request)
    {
        $token_explode = explode(" ",$request->header("Authorization"));
        $access_token = $token_explode[1];
        $admin_login = TokenManagement::where("access_token",$access_token)->first();
        $admin_login->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Logout successfully'
        ],200);
    }
}
