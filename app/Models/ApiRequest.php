<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiRequest extends Model
{
    use HasFactory;

    public const MAX_GUEST_REQ_PER_HOUR = 5;
    public const MAX_IDENTICAL_REQ = 3;

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

    private static function countGuestRequestInHour(): int
    {
        return self::where('ip', request()->ip())
            ->whereNull('user_id')
            ->whereBetween('hit_at', [Carbon::now()->subHour(), Carbon::now()])
            ->count();
    }

    public static function isGuestRequestPerHourExceeded(): bool
    {
        return self::countGuestRequestInHour() >= self::MAX_GUEST_REQ_PER_HOUR;
    }

    private static function countIdenticalRequest(): int
    {
        $requests = self::when(
            auth()->check(),
            function (Builder $query) {
                $query->where('user_id', auth()->id());
            },
            function (Builder $query) {
                $query->where('ip', request()->ip());
            }
        )->latest()->take(3)->get();

        return $requests
            ->where('query', request('location', ''))
            ->count();
    }

    public static function isMaxIdenticalRequestExceeded(): bool
    {
        return self::countIdenticalRequest() >= self::MAX_IDENTICAL_REQ;
    }
}
