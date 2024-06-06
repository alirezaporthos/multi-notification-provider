<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserPrefrence extends Model
{
    use HasFactory;

    protected $fillable = ['notification_prefrences'];

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
