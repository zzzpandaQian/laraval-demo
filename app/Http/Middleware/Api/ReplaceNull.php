<?php

namespace App\Http\Middleware\Api;

use Closure;

class ReplaceNull
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
        $response = $next($request);
        $data = json_decode($response->getContent(), true);
        if (isset($data['data'])) {
            $newData = $this->_unsetNull($data['data']);
            $data['data'] = $newData;
            return $response->setContent(json_encode($data));
        }
        return $response;
    }

    public function _unsetNull($arr)
    {
        if ($arr !== null) {
            if (is_array($arr)) {
                if (!empty($arr)) {
                    foreach ($arr as $key => $value) {
                        if ($value === null) {
                            $arr[$key] = '';
                        } else {
                            $arr[$key] = $this->_unsetNull($value);
                        }
                    }
                }
            } else {
                if ($arr === null) {
                    $arr = '';
                }
            }
        } else {
            $arr = '';
        }
        return $arr;
    }
}
