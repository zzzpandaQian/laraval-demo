<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'portfolio_id',
        'portfolio_introduction_id',
        'title',
        'description'
    ];

    public function portfolio()
    {
        return $this->belongsTo(Portfolio::class);
    }

    public function portfolioIntroduction()
    {
        return $this->belongsTo(PortfolioIntroduction::class);
    }
}
