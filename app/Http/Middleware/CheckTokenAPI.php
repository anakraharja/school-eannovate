<?php

namespace App\Http\Middleware;

use App\TokenManagement;
use Closure;

class CheckTokenAPI
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token_request = $request->header('Authorization');
        if(empty($token_request)){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
                'error' => 'Authorization is empty!'
            ],401);
        }
        $explode_token = explode(" ", $token_request);
        if(count($explode_token) != 2){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
                'error' => 'Authorization format is invalid!',
            ],401);
        }
        if(trim($explode_token[0]) != 'Bearer'){
            return response()->json([
                'status' => 401,
                'message' => 'Unauthorized',
                'error' => 'Authorization must be a Bearer!',
            ],401);
        }
        $token = trim($explode_token[1]);
        $token_check = TokenManagement::where('access_token', $token)->first();
        if(empty($token_check)){
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized',
                'error' => 'Invalid authorization access token!'
            ],403);
        }
        if(strtotime($token_check->expired_at) < time() || $token_check->active != 1){
            return response()->json([
                'status' => 403,
                'message' => 'Unauthorized',
                'error' => 'Authorization access token is already expired!'
            ],403);
        }
        return $next($request);
    }
}
