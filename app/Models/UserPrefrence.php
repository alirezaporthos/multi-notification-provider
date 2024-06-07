<?php

namespace App\Models;

use App\Events\UserPrefrenceCreated;
use App\Events\UserPrefrenceSaved;
use App\Events\UserPrefrenceUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPrefrence extends Model
{
    use HasFactory;

    protected $fillable = ['notification_prefrences'];

    protected $dispatchesEvents = [
        'saved' => UserPrefrenceSaved::class,
    ];

    protected function casts(): array
    {
        return [
            'notification_prefrences' => 'array',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
