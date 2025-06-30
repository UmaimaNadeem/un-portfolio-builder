<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserProfileLink extends Model
{
    protected $fillable = [
        'user_id', 'website_name', 'stack', 'overview', 'portfolio_link',
        'github', 'linkedin', 'whatsapp', 'instagram', 'cv_resume'
    ];
}
