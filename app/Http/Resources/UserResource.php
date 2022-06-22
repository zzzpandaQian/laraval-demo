<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class UserResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    // 'status'
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'email'       => $this->email,
            'mobile'      => $this->mobile,
            'gender'      => $this->gender,
            'birthdate'   => $this->birthdate,
            'wx_avatar'   => $this->wx_avatarUrl,
            'avatar'      => $this->avatarUrl,
            'address'     => $this->address,
            'wx_openid'   => $this->wx_openid,
            'xcx_openid'  => $this->xcx_openid,
            'unionid'     => $this->unionid,
            'wx_nickname' => $this->wx_nickname,
            'oauth_scope' => $this->oauth_scope,
            'status'      => $this->status,
            'created_at'  => optional($this->created_at)->toDateTimeString(),
        ];
    }
}
