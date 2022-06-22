<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Demo extends Model
{
    protected $fillable = [
        'id',
        'title',
        'content',
        'email',
        'password',
        'url',
        'ip',
        'mobile',
        'color',
        'currency',
        'number',
        'rate',
        'editor',
        'switch',
        'icon',
        'radio',
        'checkbox',
        'select',
        'multipleSelect',
        'timezone',
        'time',
        'date',
        'datetime',
        'timeRangeStart',
        'timeRangeEnd',
        'dateRangeStart',
        'dateRangeEnd',
        'datetimeRangeStart',
        'datetimeRangeEnd',
        'image',
        'multipleImage',
        'file',
        'multipleFile',
        'latitude',
        'longitude',
        'listbox',
        'nationality',
        'name',
        'idcard',
        'slider',
        'passport',
    ];

    public function getMultipleSelectAttribute($value)
    {
        return explode(',', $value);
    }

    public function setMultipleSelectAttribute($value)
    {
        $this->attributes['multipleSelect'] = implode(',', $value);
    }

    public function getListboxAttribute($value)
    {
        return explode(',', $value);
    }

    public function setListboxAttribute($value)
    {
        $this->attributes['listbox'] = implode(',', $value);
    }

    public function getCheckboxAttribute($value)
    {
        return explode(',', $value);
    }

    public function setCheckboxAttribute($value)
    {
        $this->attributes['checkbox'] = implode(',', $value);
    }

    public function getImageUrlAttribute()
    {
        return getimageUrl($this->image);
    }

    public function getFileUrlAttribute()
    {
        return getimageUrl($this->file);
    }

    public function setMultipleImageAttribute($multipleImage)
    {
        if (is_array($multipleImage)) {
            $this->attributes['multipleImage'] = json_encode($multipleImage);
        }
    }

    public function getMultipleImageAttribute($multipleImage)
    {
        return json_decode($multipleImage, true);
    }

    public function getMultipleImageUrlAttribute()
    {
        return getMoreImagesUrl($this->attributes['multipleImage']);
    }


    public function setMultipleFileAttribute($multipleFile)
    {
        if (is_array($multipleFile)) {
            $this->attributes['multipleFile'] = json_encode($multipleFile);
        }
    }

    public function getMultipleFileAttribute($multipleFile)
    {
        return json_decode($multipleFile, true);
    }

    public function getMultipleFileUrlAttribute()
    {
        return getMoreImagesUrl($this->attributes['multipleFile']);
    }
}
