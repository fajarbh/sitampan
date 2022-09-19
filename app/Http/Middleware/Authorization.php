<?php 

namespace App\Http\Middleware;
use Closure;
use App\Helpers\Context;
use App\Models\User;

class Authorization {

  public function handle($request, Closure $next){
    $user = User::where('api_token','!=',null)->where('api_token',$request->header('Authorization'))->first();
    if($user != null){
      if($user->is_verified == 0){
        $data = [
          'total_data' => 0,
          'status_code' => 401,
          'message' => 'Akun Belum Diverifikasi',
        ];
        return response()->json($data,401);
      }else{
        $user = [
          'id' => $user->id,
          'nik' => $user->nik,
          'level' => $user->level,
          'api_token' => $user->api_token
        ];
        Context::setUser($user);
        return $next($request);
      }
    }else{
      return response()->json(['message'=>'Unauthorized'],401);
    }
  }
}