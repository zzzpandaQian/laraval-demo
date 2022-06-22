<?php

namespace App\Models;

use Encore\Admin\Auth\Database\Administrator as AdminModel;

class Administrator extends AdminModel
{
    /**
     * Get avatar attribute.
     *
     * @param string $avatar
     *
     * @return string
     */
    public function getAvatarAttribute($avatar)
    {
        $disk = config('admin.upload.disk');

        if ($avatar && array_key_exists($disk, config('filesystems.disks'))) {
            return \Storage::disk(config('admin.upload.disk'))->url($avatar);
        }

        return asset('/images/admin/avatar.png');
    }
}
