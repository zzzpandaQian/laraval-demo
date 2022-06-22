<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Exceptions\InternalException;

class PortfolioIntroduction extends Model
{
    protected $fillable = ['title', 'content', 'portfolio_id'];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function project()
    {
        return $this->hasMany(Project::class);
    }
}
