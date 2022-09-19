<?php 

namespace App\Http\Middleware;
use Closure;
use App\Models\User;
use App\Models\Farmer;
use App\Helpers\Context;

class AuthorizeFarmer {

  public function handle($request,Closure $next){
    if(Context::user() != null && Context::user()['level'] == 4){
          $farmer = Farmer::where('id_user', Context::user()['id'])->first();
          Context::setUser(array_merge(Context::user(), array(
            'id_petani' => $farmer->id,
            'id_kelompok' => $farmer->id_kelompok,
            'id_desa' => $farmer->id_desa,
          )));
          return $next($request);
    }else{
      return response()->json(['message'=>'Unauthorized'],401);
    }
  }

}