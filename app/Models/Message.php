<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Message extends Model
{
    protected $fillable = [
        'type',
        'writed_by',
        'reply_by',
        'message',
        'response',
        'writed_at',
        'responsed_at',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'writed_at' => 'datetime',
            'responsed_at' => 'datetime',
        ];
    }

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'writed_by');
    }

    public function replier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reply_by');
    }
}
