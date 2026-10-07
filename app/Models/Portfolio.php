<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Portfolio extends Model
{
    public const TYPES = [
        'developer' => ['label' => 'Developer', 'icon' => 'bi-code-slash', 'blurb' => 'Apps, APIs, and engineering craft'],
        'designer' => ['label' => 'Designer', 'icon' => 'bi-palette', 'blurb' => 'UI, brand, and visual systems'],
        'seo' => ['label' => 'SEO Specialist', 'icon' => 'bi-graph-up-arrow', 'blurb' => 'Search growth and content strategy'],
        'sqa' => ['label' => 'SQA / QA Engineer', 'icon' => 'bi-shield-check', 'blurb' => 'Quality, automation, and reliability'],
        'marketing' => ['label' => 'Marketer', 'icon' => 'bi-megaphone', 'blurb' => 'Campaigns, funnels, and demand'],
        'writer' => ['label' => 'Writer / Content', 'icon' => 'bi-pen', 'blurb' => 'Stories, copy, and editorial work'],
        'photographer' => ['label' => 'Photographer', 'icon' => 'bi-camera', 'blurb' => 'Visual storytelling and shoots'],
        'product' => ['label' => 'Product Manager', 'icon' => 'bi-kanban', 'blurb' => 'Roadmaps, discovery, and delivery'],
        'data' => ['label' => 'Data / Analytics', 'icon' => 'bi-bar-chart', 'blurb' => 'Insights, models, and dashboards'],
        'devops' => ['label' => 'DevOps / Cloud', 'icon' => 'bi-cloud', 'blurb' => 'Infra, CI/CD, and platforms'],
        'freelancer' => ['label' => 'Freelancer', 'icon' => 'bi-briefcase', 'blurb' => 'Multi-skill client work'],
        'other' => ['label' => 'Other / Custom', 'icon' => 'bi-stars', 'blurb' => 'Your own field or niche'],
    ];

    protected $fillable = [
        'user_id',
        'theme_id',
        'title',
        'type',
        'slug',
        'status',
    ];

    public static function typeKeys(): array
    {
        return array_keys(self::TYPES);
    }

    public function typeMeta(): array
    {
        return self::TYPES[$this->type] ?? self::TYPES['other'];
    }

    public function typeLabel(): string
    {
        return $this->typeMeta()['label'];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function theme(): BelongsTo
    {
        return $this->belongsTo(Theme::class);
    }

    public function personalInfo(): HasOne
    {
        return $this->hasOne(PersonalInfo::class);
    }

    public function profileLink(): HasOne
    {
        return $this->hasOne(UserProfileLink::class);
    }

    public function educations(): HasMany
    {
        return $this->hasMany(Education::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    public function workExperiences(): HasMany
    {
        return $this->hasMany(WorkExperience::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    public function arModels(): HasMany
    {
        return $this->hasMany(ArModel::class);
    }

    public function isPublic(): bool
    {
        return $this->status === 'public';
    }

    public function isOwnedBy(?int $userId): bool
    {
        return $userId !== null && $this->user_id === $userId;
    }

    public function scopePublic($query)
    {
        return $query->where('status', 'public');
    }
}
