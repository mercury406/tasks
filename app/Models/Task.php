<?php

namespace App\Models;

use App\Enums\TaskStatus;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property int $user_id
 * @property int $status
 *
 * @property BelongsTo<User> $user
 * @method static forUser(int $userId)
 */
class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $casts = [
        'status' => TaskStatus::class
    ];

    protected $fillable = [
        'title',
        'slug',
        'description',
        'user_id',
        'status'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeForUser(Builder $q, int $userId): void
    {
        $q->where('user_id', $userId);
    }

    public function slug(): Attribute
    {
        return Attribute::make(
            set: fn($value) => str()->slug($value)
        );
    }
}
