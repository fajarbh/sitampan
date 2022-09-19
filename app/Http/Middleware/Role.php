<?php

namespace App\Http\Middleware;

// Bagian memanggil komponen
use Closure;
use Auth;
use Cache;
use Carbon\Carbon;
use Helper;

class Role
{
    /**
     * Bagian validasi multiuser perhatikan parameternya
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if (Helper::roleName(Auth::user()->level) == $role) {

                    // bagian untuk ngecek user yg online
                    // cek function isOnline di user.php
                    // perhatikan bagian atas
                    if (Auth::check())
                    {
                        $expiresAt = Carbon::now()->addMinutes(1);
                        Cache::put('user-is-online-' . Auth::user()->id_user, true, $expiresAt);
                    }
                    return $next($request);
                }
            }
            return abort(404);
        }
    }
}
