<?php

namespace App\Models;

use Barryvdh\LaravelIdeHelper\Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Carbon;

/**
 * App\Models\RefreshToken
 *
 * @property int $id
 * @property string $user_type
 * @property int $user_id
 * @property string|null $fingerprint
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|Eloquent $user
 * @method static Builder|RefreshToken newModelQuery()
 * @method static Builder|RefreshToken newQuery()
 * @method static Builder|RefreshToken query()
 * @method static Builder|RefreshToken whereCreatedAt($value)
 * @method static Builder|RefreshToken whereFingerprint($value)
 * @method static Builder|RefreshToken whereId($value)
 * @method static Builder|RefreshToken whereUpdatedAt($value)
 * @method static Builder|RefreshToken whereUserId($value)
 * @method static Builder|RefreshToken whereUserType($value)
 * @mixin Eloquent
 * @mixin \Eloquent
 */
class RefreshToken extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_type',
        'user_id',
        'fingerprint',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'user_id' => 'integer'
    ];

    /**
     * @return MorphTo
     */
    public function user(): MorphTo
    {
        return $this->morphTo();
    }
}
