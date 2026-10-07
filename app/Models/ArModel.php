<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArModel extends Model
{
    use HasFactory;

    protected $table = 'ar_models';

    protected $fillable = [
        'user_id',
        'portfolio_id',
        'gltf',
        'bin',
        'textures',
    ];

    protected $casts = [
        'textures' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
