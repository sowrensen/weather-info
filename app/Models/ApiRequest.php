<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'ip',
        'query',
        'hit_at',
        'user_id'
    ];

    protected $dates = [
        'hit_at'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function recordRequest($query)
    {
        self::create([
            'ip' => request()->ip(),
            'query' => $query,
            'hit_at' => now(),
            'user_id' => auth()->check() ? auth()->id() : null
        ]);
    }
}
