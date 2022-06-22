<?php

use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Request;
use Illuminate\Contracts\Support\Arrayable;

function route_class()
{
    return str_replace('.', '-', Route::currentRouteName());
}

function getIpInfo($ip = '')
{
    if (empty($ip)) {
        return false;
    }

    // 淘宝ip接口
    // $res = @file_get_contents('http://ip.taobao.com/service/getIpInfo.php?ip=' . $ip);
    // if (empty($res)) {
    //     return false;
    // }
    // $json = json_decode($res, true);
    // if (isset($json['code']) && $json['code'] == 0) {
    //     $json['ip'] = $ip;
    //     unset($json['ret']);
    // } else {
    //     return false;
    // }
    // return $json['data'];


    // ip-api.com
    $res = @file_get_contents('http://ip-api.com/json/' . $ip . '?lang=zh-CN');
    if (empty($res)) {
        return false;
    }
    $json = json_decode($res, true);
    if (isset($json['status']) && $json['status'] == 'success') {
        return $json;
    } else {
        return false;
    }
}

if (!function_exists('isMobile')) {
    /**
     * 检测是否是移动端浏览器
     *
     * @return bool
     */
    function isMobile()
    {
        $mobiles = ['Mobile', 'iPad', 'Android', 'iPhone', 'Silk', 'Kindle', 'BlackBerry', 'Opera Mini', 'Opera Mobi'];

        return Str::contains(Request::server('HTTP_USER_AGENT'), $mobiles);
    }
}

if (!function_exists('isWeChat')) {
    /**
     * 检测是否是微信浏览器
     *
     * @return bool
     */
    function isWeChat()
    {
        return Str::contains(Request::server('HTTP_USER_AGENT'), ['MicroMessenger']);
    }
}

if (!function_exists('convertFileSize')) {
    /**
     * 转换文件大小
     *
     * @param int $size
     *
     * @return string
     */
    function convertFileSize($size)
    {
        if ($size >= pow(2, 40)) {
            $size = round($size / pow(2, 40), 2);
            $dw = "TB";
        } elseif ($size >= pow(2, 30)) {
            $size = round($size / pow(2, 30), 2);
            $dw = "GB";
        } elseif ($size >= pow(2, 20)) {
            $size = round($size / pow(2, 20), 2);
            $dw = "MB";
        } elseif ($size >= pow(2, 10)) {
            $size = round($size / pow(2, 10), 2);
            $dw = "KB";
        } else {
            $dw = "Bytes";
        }

        return $size . $dw;
    }
}

if (!function_exists('formatChineseName')) {
    /**
     * @param      $firstName
     * @param null $lastName
     *
     * @return string
     */
    function formatChineseName($firstName, $lastName = null)
    {
        $preg = chr(0xa1) . "-" . chr(0xff);
        $first = preg_match("/[$preg]+/", $firstName, $mF);
        $last = preg_match("/[$preg]+/", $lastName, $mL);
        if ($first || $last) {
            return $lastName . $firstName;
        }

        return $firstName . ' ' . $lastName;
    }
}

if (!function_exists('toArray')) {
    /**
     * 转换为数组
     *
     * @param mixed|null $value
     *
     * @return array
     */
    function toArray($value = null)
    {
        $value = value($value);
        if (is_array($value)) {
            return $value;
        }
        if ($value instanceof Arrayable) {
            return $value->toArray();
        }

        return !empty($value) ? (array)$value : [];
    }
}

if (!function_exists('arrayToTree')) {
    /**
     * 转换为树形
     *
     * @param array       $data
     * @param string|null $p_id
     * @param string      $pIdKey
     * @param string      $idKey
     * @param string      $childrenKey
     *
     * @return array
     */
    function arrayToTree(array $data = [], $p_id = null, $pIdKey = 'p_id', $idKey = 'id', $childrenKey = 'children')
    {
        $branch = [];
        foreach ($data as $item) {
            if ($item[$pIdKey] == $p_id) {
                $item['checkArr'] = [
                    "type" => "0",
                    "checked" => "0",
                ];
                $children = arrayToTree($data, $item[$idKey], $pIdKey, $idKey, $childrenKey);
                if ($children) {
                    $item[$childrenKey] = $children;
                }
                $branch[] = $item;
            }
        }

        return $branch;
    }
}

/**
 * 图片处理 单图
 *
 * @param [type] $image
 * @return void
 */
function getimageUrl($image)
{
    if ($image) {
        if (Str::startsWith($image, ['http://', 'https://'])) {
            if (@fopen($image, 'r')) {
                return $image;
            } else {
                return asset('images/placeholder.png');
            }
        }
        return \Storage::disk('public')->url($image);
    }

    return asset('images/placeholder.png');
}

/**
 * 多图处理
 *
 * @param [type] $more_images
 * @return void
 */
function getMoreImagesUrl($more_images)
{
    $more_images = json_decode($more_images);
    $more_images_url = [];

    if (is_array($more_images) && !empty($more_images)) {
        foreach ($more_images as $image) {
            // 如果 image 字段本身就已经是完整的 url 就直接返回
            if (Str::startsWith($image, ['http://', 'https://'])) {
                $more_images_url[] = $image;
            } else {
                $more_images_url[] = \Storage::disk('public')->url($image);
            }
        }
    }

    return $more_images_url;
}

/**
 * 多图进行裁剪
 *
 * @param [type] $more_images
 * @return void
 */
function getMoreImagesUrlThumb($more_images)
{
    $more_images = json_decode($more_images, true);
    $images_url = [];

    if (is_array($more_images) && !empty($more_images)) {
        foreach ($more_images as $image) {
            if (Str::startsWith($image, ['http://', 'https://'])) {
                $world = strpos($image, 'images/');
                $image = str_replace(substr($image, 0, $world), "", $image);
            }

            $images = explode(".", $image);
            $storage_image = 'storage/' . $images[0] . '-thumb.' . $images[1];
            $save_image = $images[0] . '-thumb.' . $images[1];

            if (file_exists(storage_path('app\\public\\' . $save_image))) {
                // $images_url[] = storage_path('app\\public\\' . $save_image);
                $images_url[] = \Storage::disk('public')->url($save_image);
            } else {
                $image  = Image::make('storage/' . $image)->resize(300, null, function ($constraint) {
                    $constraint->aspectRatio();
                })->save($storage_image);
                // $images_url[] = storage_path('app\\public\\' . $save_image);
                $images_url[] = \Storage::disk('public')->url($save_image);
            }
        }
    }
    return $images_url;

    // $more_images = json_decode($more_images, true);
    // $images_url = [];

    // if (is_array($more_images) && !empty($more_images)) {
    //     foreach ($more_images as $image) {
    //         // 如果 image 字段本身就已经是完整的 url 就直接返回
    //         if (Str::startsWith($image, ['http://', 'https://'])) {
    //             if (@fopen($image, 'r')) {
    //                 $images_url[] = $image;
    //             }
    //         } else {
    //             $images = explode(".", $image);
    //             $image_ext = $images[count($images) - 1];
    //             $image_url_pre = str_replace("." . $image_ext, "", $image);

    //             $new_image = $image_url_pre . '-large.' . $image_ext;
    //             $storage_image = 'storage/' . $new_image;

    //             if (file_exists(public_path($storage_image))) {
    //                 $images_url[] = \Storage::disk('public')->url($new_image);
    //             } else {
    //                 if (file_exists(public_path('storage/' . $image))) {
    //                     Image::make('storage/' . $image)->fit(540, 540)->save($storage_image);
    //                     $images_url[] = \Storage::disk('public')->url($new_image);
    //                 }
    //             }
    //         }
    //     }
    // }
    // return $images_url;
}
