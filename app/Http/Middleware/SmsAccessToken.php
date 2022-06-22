<?php

namespace App\Http\Middleware;

use Closure;

class SmsAccessToken
{
    /**
     * Handle an incoming request.
     *
     * https://github.com/toplan/laravel-sms/issues/180
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->has('mobile')) { // 根据前端传的字段自定义配置
            $request->headers->set('access-token', $request->input('mobile'));
        }
        return $next($request);
    }
}
