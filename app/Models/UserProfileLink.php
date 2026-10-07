<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserProfileLink extends Model
{
    protected $fillable = [
        'user_id',
        'portfolio_id',
        'website_name',
        'stack',
        'overview',
        'portfolio_link',
        'github',
        'linkedin',
        'whatsapp',
        'instagram',
        'cv_resume',
    ];

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
